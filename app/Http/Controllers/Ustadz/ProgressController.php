<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Helpers\QuranData;
use App\Models\Santri;
use App\Models\SantriAttendance;
use App\Models\SqrClass;
use App\Models\StudentProgress;
use App\Models\UstadzAttendance;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $user    = auth()->user();
        $classes = SqrClass::where('is_active', true)->get();

        // Selected class or ustadz's default class
        $selectedClassId = $request->get('class_id', $user->sqrClass?->id ?? $classes->first()?->id);
        $selectedClass   = SqrClass::find($selectedClassId);

        // Check if current user is primary teacher or substitute teacher for today
        $isPrimaryTeacher = $selectedClass && ($selectedClass->ustadz_id === $user->id);
        $isSubstituteToday = false;

        if ($selectedClass) {
            $isSubstituteToday = UstadzAttendance::where('substitute_ustadz_id', $user->id)
                ->whereDate('date', today())
                ->exists()
                || SantriAttendance::where('class_id', $selectedClass->id)
                    ->where('substitute_ustadz_id', $user->id)
                    ->whereDate('date', today())
                    ->exists();
        }

        $santriList = collect();

        if ($selectedClass) {
            $rawList = $selectedClass->activeSantri()->with('studentProgress')->get();

            // Attach today's attendance status to each santri
            $todayAttendances = SantriAttendance::where('class_id', $selectedClass->id)
                ->whereDate('date', today())
                ->get()
                ->keyBy('santri_id');

            $santriList = $rawList->map(function ($santri) use ($todayAttendances) {
                $att = $todayAttendances->get($santri->id);
                $santri->today_attendance = $att;
                $santri->today_status = $att?->status ?? 'Belum Diabsen';
                // Only allow input progress if santri is marked Present/Permission/Sick today
                $santri->can_input_progress = $att && in_array($att->status, ['Hadir', 'Izin', 'Sakit']);
                return $santri;
            });
        }

        return view('ustadz.progress.index', compact(
            'classes', 'selectedClass', 'selectedClassId', 'santriList',
            'isPrimaryTeacher', 'isSubstituteToday'
        ));
    }

    public function santriByClass(SqrClass $class)
    {
        $todayAttendances = SantriAttendance::where('class_id', $class->id)
            ->whereDate('date', today())
            ->get()
            ->keyBy('santri_id');

        $santriList = $class->activeSantri()->get()->map(function ($santri) use ($todayAttendances) {
            $att = $todayAttendances->get($santri->id);
            $santri->today_status = $att?->status ?? 'Belum Diabsen';
            $santri->can_input_progress = $att && in_array($att->status, ['Hadir', 'Izin', 'Sakit']);
            return $santri;
        });

        return response()->json($santriList);
    }

    public function create(Santri $santri)
    {
        $santri->load(['sqrClass', 'wali']);

        // Check today's attendance for this santri
        $todayAttendance = SantriAttendance::where('santri_id', $santri->id)
            ->whereDate('date', today())
            ->first();

        $canInputProgress = $todayAttendance && in_array($todayAttendance->status, ['Hadir', 'Izin', 'Sakit']);
        $todayStatus      = $todayAttendance?->status ?? 'Belum Diabsen';

        $surahList = StudentProgress::$surahList;
        $juzMap    = QuranData::$juzMap;

        $recentProgress = $santri->studentProgress()
            ->with('ustadz')
            ->latest('date')
            ->latest('id')
            ->limit(15)
            ->get();

        $lastProgress = $recentProgress->first();

        // Calculate progress stats
        $totalJuz    = $santri->total_juz_memorised;
        $progressPct = $santri->progress_percentage;

        return view('ustadz.progress.create', compact(
            'santri',
            'surahList',
            'juzMap',
            'recentProgress',
            'lastProgress',
            'totalJuz',
            'progressPct',
            'todayAttendance',
            'canInputProgress',
            'todayStatus'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id'       => 'required|exists:santri,id',
            'date'            => 'required|date',
            'type'            => 'required|in:Tahsin,Tahfiz,Murojaah',
            'juz_start'       => 'nullable|integer|min:1|max:30',
            'juz_end'         => 'nullable|integer|min:1|max:30',
            'surah_memorized' => 'nullable|string|max:200',
            'verse_start'     => 'nullable|integer|min:1',
            'verse_end'       => 'nullable|integer|min:1',
            'rating'          => 'nullable|string|max:50',
            'notes'           => 'nullable|string|max:500',
        ]);

        $santri = Santri::findOrFail($validated['santri_id']);

        // 1. Check if santri was attended today (if date is today)
        if (Carbon\Carbon::parse($validated['date'])->isToday()) {
            $todayAtt = SantriAttendance::where('santri_id', $santri->id)
                ->whereDate('date', today())
                ->first();

            if (!$todayAtt || !in_array($todayAtt->status, ['Hadir', 'Izin', 'Sakit'])) {
                return back()
                    ->withInput()
                    ->with('error', "⚠️ Santri {$santri->full_name} belum di-absen hadir hari ini. Harap lakukan presensi kehadiran terlebih dahulu sebelum menginput progress!");
            }
        }

        // 2. Check for duplicate Tahfiz setoran
        $isDuplicate = false;
        if ($validated['type'] === 'Tahfiz' && !empty($validated['surah_memorized'])) {
            $isDuplicate = StudentProgress::where('santri_id', $santri->id)
                ->where('type', 'Tahfiz')
                ->where('surah_memorized', $validated['surah_memorized'])
                ->where('juz_start', $validated['juz_start'] ?? null)
                ->exists();
        }

        // Combine surah, verse, rating and notes
        $surahFinal = $validated['surah_memorized'];
        if ($surahFinal && !empty($validated['verse_start'])) {
            $verseRange = $validated['verse_start'];
            if (!empty($validated['verse_end']) && $validated['verse_end'] != $validated['verse_start']) {
                $verseRange .= '-' . $validated['verse_end'];
            }
            $surahFinal .= " (Ayat {$verseRange})";
        }

        $notesCombined = '';
        if (!empty($validated['rating'])) {
            $notesCombined .= "⭐ Predikat: " . $validated['rating'];
        }
        if (!empty($validated['notes'])) {
            $notesCombined .= ($notesCombined ? " | " : "") . $validated['notes'];
        }

        StudentProgress::create([
            'santri_id'       => $validated['santri_id'],
            'date'            => $validated['date'],
            'type'            => $validated['type'],
            'juz_start'       => $validated['juz_start'] ?? null,
            'juz_end'         => $validated['juz_end'] ?? null,
            'surah_memorized' => $surahFinal,
            'notes'           => $notesCombined ?: null,
            'ustadz_user_id'  => auth()->id(),
        ]);

        $message = "Progress {$santri->full_name} ({$validated['type']}) berhasil disimpan!";
        if ($isDuplicate) {
            $message .= " ℹ️ Catatan: Surah {$validated['surah_memorized']} ini sudah pernah disetorkan sebelumnya (persentase progress baru tidak dihitung ganda).";
        }

        return redirect()
            ->route('ustadz.progress.create', $santri)
            ->with('success', $message);
    }

    public function destroy(StudentProgress $progress)
    {
        $santriId = $progress->santri_id;
        $progress->delete();
        return back()->with('success', 'Progress hafalan berhasil dihapus.');
    }
}
