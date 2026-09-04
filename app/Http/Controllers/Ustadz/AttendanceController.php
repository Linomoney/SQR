<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriAttendance;
use App\Models\SqrClass;
use App\Models\SchoolSchedule;
use App\Models\SqrLocation;
use App\Models\SqrNotification;
use App\Models\UstadzAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $ustadz = auth()->user();
        $myClass = $ustadz->sqrClass;
        $classes = SqrClass::where('is_active', true)->get();
        $allUstadz = User::role('ustadz')->get();

        // Ustadz's own attendance today
        $todaySelf = UstadzAttendance::where('ustadz_id', $ustadz->id)
            ->whereDate('date', today())
            ->first();

        $canRecordSantriAttendance = $todaySelf && in_array($todaySelf->status, ['Hadir', 'Hadir Online']);

        // Ustadz's attendance history (last 30 days)
        $myAttendanceHistory = UstadzAttendance::where('ustadz_id', $ustadz->id)
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        // Monthly stats for Ustadz
        $startOfMonth = today()->startOfMonth();
        $endOfMonth   = today()->endOfMonth();

        $monthAttendances = UstadzAttendance::where('ustadz_id', $ustadz->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();

        $myStats = [
            'total_hadir' => $monthAttendances->whereIn('status', ['Hadir', 'Hadir Online'])->count(),
            'total_izin'  => $monthAttendances->where('status', 'Izin')->count(),
            'total_sakit' => $monthAttendances->where('status', 'Sakit')->count(),
            'total_days'  => $monthAttendances->count(),
            'percentage'  => $monthAttendances->count() > 0 
                ? round(($monthAttendances->whereIn('status', ['Hadir', 'Hadir Online'])->count() / $monthAttendances->count()) * 100)
                : 100,
        ];

        // Selected class and date filter
        $selectedClassId = $request->get('class_id', $myClass?->id ?? $classes->first()?->id);
        $selectedDate    = $request->get('date', today()->format('Y-m-d'));

        // History logs filters: single date, date range, or month/year
        $filterType = $request->get('filter_type', 'month'); // 'single', 'range', 'month'
        $filterDate = $request->get('filter_date');
        $startDate  = $request->get('start_date');
        $endDate    = $request->get('end_date');
        $month      = $request->get('month', today()->format('m'));
        $year       = $request->get('year', today()->format('Y'));

        $logsQuery = SantriAttendance::with(['santri', 'sqrClass', 'recordedBy', 'substituteUstadz']);

        if ($selectedClassId) {
            $logsQuery->where('class_id', $selectedClassId);
        }

        if ($filterType === 'single' && $filterDate) {
            $logsQuery->whereDate('date', $filterDate);
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $logsQuery->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate && $endDate) {
            $logsQuery->whereBetween('date', [$startDate, $endDate]);
        } elseif ($filterDate) {
            $logsQuery->whereDate('date', $filterDate);
        } else {
            $logsQuery->whereMonth('date', $month)->whereYear('date', $year);
        }

        $recentSantriAttendanceLogs = $logsQuery->latest('date')
            ->take(120)
            ->get()
            ->groupBy(function ($item) {
                return $item->date->format('Y-m-d') . '_' . $item->class_id;
            });

        $userLocation = $ustadz->location ?? \App\Models\SqrLocation::getDefaultLocation();

        return view('ustadz.attendance.index', compact(
            'ustadz',
            'myClass',
            'classes',
            'allUstadz',
            'todaySelf',
            'canRecordSantriAttendance',
            'myAttendanceHistory',
            'myStats',
            'selectedClassId',
            'selectedDate',
            'recentSantriAttendanceLogs',
            'userLocation'
        ));
    }

    public function storeSelf(Request $request)
    {
        $ustadz = auth()->user();
        $validated = $request->validate([
            'status'               => 'required|in:Hadir,Hadir Online,Izin,Sakit,Alpa',
            'notes'                => 'nullable|string|max:255',
            'substitute_ustadz_id' => 'nullable|exists:users,id',
            'online_meeting_link'  => 'nullable|string|max:500',
            'online_start_time'    => 'nullable|string|max:10',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
        ]);

        $userLocation = $ustadz->location ?? \App\Models\SqrLocation::getDefaultLocation();
        $sqrLat       = $userLocation ? (float)$userLocation->latitude : SchoolSchedule::sqrLatitude();
        $sqrLng       = $userLocation ? (float)$userLocation->longitude : SchoolSchedule::sqrLongitude();
        $sqrRadius    = $userLocation ? (int)$userLocation->radius_meters : SchoolSchedule::sqrRadiusMeters();
        $locationName = $userLocation ? $userLocation->name : 'TPQ SQR Utama';
        $jamMasuk     = SchoolSchedule::jamMasuk();

        $userLat  = $request->filled('latitude') ? (float)$request->input('latitude') : null;
        $userLng  = $request->filled('longitude') ? (float)$request->input('longitude') : null;
        $distance = null;
        $isWithin = true;

        if ($userLat && $userLng) {
            $distance = SchoolSchedule::calculateDistance($userLat, $userLng, $sqrLat, $sqrLng);
            $isWithin = ($distance <= $sqrRadius);
        }

        $existingAtt = UstadzAttendance::where('ustadz_id', $ustadz->id)->whereDate('date', today())->first();

        // Rule A: Once checked in HADIR Tatap Muka, status is final and cannot be changed to online/izin/sakit
        if ($existingAtt && $existingAtt->status === 'Hadir' && $validated['status'] !== 'Hadir') {
            return back()
                ->withInput()
                ->with('error', "⛔ Status presensi 'Hadir Tatap Muka' Anda hari ini sudah final dan tidak dapat diubah lagi.");
        }

        // Rule B: If already ALPA / Izin / Sakit, cannot change status back to Hadir Tatap Muka
        if ($existingAtt && in_array($existingAtt->status, ['Alpa', 'Izin', 'Sakit']) && $validated['status'] === 'Hadir') {
            return back()
                ->withInput()
                ->with('error', "⛔ Status presensi Anda hari ini adalah '{$existingAtt->status}'. Anda tidak dapat lagi Check-In 'Hadir Tatap Muka'. Silakan pilih 'Hadir Online' (dengan link meeting) atau 'Izin' / 'Sakit'.");
        }

        // Rule C: Notes handling when updating from ALPA
        $noteToSave = $validated['notes'] ?? null;
        if (empty($noteToSave) && $existingAtt && $existingAtt->status === 'Alpa') {
            $noteToSave = $existingAtt->notes;
        }

        // 1. GPS Geolocation Radius Check for Physical "Hadir" against assigned Branch Location
        if ($validated['status'] === 'Hadir') {
            if ($userLat && $userLng && !$isWithin) {
                return back()
                    ->withInput()
                    ->with('error', "⛔ Check-In HADIR (Fisik) Ditolak! Posisi GPS Anda ({$distance} meter) berada di luar radius lokasi mengajar Anda: {$locationName} (Maksimum radius: {$sqrRadius} meter). Harap presensi dari dalam area {$locationName} atau pilih presensi 'Hadir Online' / 'Izin'.");
            }
        }

        // 2. Time Window Check (Opens 1 hour before start time)
        if ($validated['status'] === 'Hadir') {
            $jamMasukTime = Carbon::createFromFormat('H:i', $jamMasuk);
            $windowStart  = $jamMasukTime->copy()->subHour()->format('H:i');
            $currentTime  = now()->format('H:i');

            if ($currentTime < $windowStart) {
                return back()
                    ->withInput()
                    ->with('error', "⛔ Presensi HADIR belum dibuka. Presensi HADIR baru dapat diakses 1 jam sebelum jam masuk (mulai pukul {$windowStart} WIB).");
            }
        }

        UstadzAttendance::updateOrCreate(
            [
                'ustadz_id' => $ustadz->id,
                'date'      => today(),
            ],
            [
                'status'               => $validated['status'],
                'check_in_time'        => now()->format('H:i:s'),
                'notes'                => $noteToSave,
                'substitute_ustadz_id' => $validated['substitute_ustadz_id'] ?? null,
                'online_meeting_link'  => $validated['online_meeting_link'] ?? null,
                'online_start_time'    => $validated['online_start_time'] ?? null,
                'latitude'             => $userLat ?? $existingAtt?->latitude,
                'longitude'            => $userLng ?? $existingAtt?->longitude,
                'distance_meters'      => $distance ? (int)$distance : $existingAtt?->distance_meters,
                'is_within_radius'     => $userLat && $userLng ? $isWithin : ($existingAtt?->is_within_radius ?? true),
            ]
        );

        $myClass = $ustadz->sqrClass;
        $msg = "Presensi diri Ustadz (" . $validated['status'] . ") berhasil disimpan!";

        if ($validated['status'] === 'Hadir Online') {
            $link = $validated['online_meeting_link'] ?? '#';
            $startTime = $validated['online_start_time'] ?? ($myClass?->start_time ?? '16:00');

            // Send notification to Wali Santri
            SqrNotification::create([
                'target_role' => 'wali',
                'title'       => "💻 Pengumuman KBM Daring (Online) - " . ($myClass?->name ?? 'Kelas SQR'),
                'message'     => "Kelas " . ($myClass?->name ?? '') . " hari ini (" . today()->format('d M Y') . ") dilaksanakan secara DARING (Online Zoom/Meet) mulai pukul {$startTime} WIB. Link Pertemuan: {$link}",
                'type'        => 'online_class',
                'is_read'     => false,
            ]);

            $msg .= " Notifikasi KBM Daring (Zoom/GMeet) telah dikirimkan ke Wali Santri.";
        } elseif (!empty($validated['substitute_ustadz_id'])) {
            $subUstadz = User::find($validated['substitute_ustadz_id']);
            $msg .= " Ustadz Pengganti ditugaskan: Ust. {$subUstadz?->name}.";
        }

        return redirect()->route('ustadz.attendance.index', [
            'tab'      => 'santri',
            'class_id' => $myClass?->id,
        ])->with('success', $msg);
    }

    public function storeSantri(Request $request)
    {
        $ustadz = auth()->user();
        $dateFormatted = Carbon::parse($request->input('date', today()))->format('Y-m-d');
        $isToday = $dateFormatted === today()->format('Y-m-d');

        // Rule 1: No Future Dates Allowed
        if ($dateFormatted > today()->format('Y-m-d')) {
            return back()->with('error', '⛔ Tidak dapat melakukan presensi untuk tanggal di masa mendatang (future date).');
        }

        $validated = $request->validate([
            'class_id'             => 'required|exists:classes,id',
            'date'                 => 'required|date',
            'status'               => 'required|array',
            'status.*'             => 'required|in:Hadir,Izin,Sakit,Alpa',
            'notes'                => 'nullable|array',
            'notes.*'              => 'nullable|string|max:255',
            'substitute_ustadz_id' => 'nullable|exists:users,id',
        ]);

        $sqrClass = SqrClass::find($validated['class_id']);
        if (!$sqrClass) {
            return back()->with('error', 'Kelas tidak ditemukan.');
        }

        $perm = $this->resolveClassPermission($sqrClass, $dateFormatted, $ustadz);
        if (!$perm['can_record']) {
            return back()->with('error', $perm['reason']);
        }

        // Rule: Check-in Hadir / Hadir Online required if user is recording today (unless Admin)
        if ($isToday && !$ustadz->hasRole('admin')) {
            $mySelfAttendance = UstadzAttendance::where('ustadz_id', $ustadz->id)
                ->whereDate('date', today())
                ->first();

            if (!$mySelfAttendance || !in_array($mySelfAttendance->status, ['Hadir', 'Hadir Online'])) {
                return back()->with('error', '⛔ Anda belum check-in HADIR / HADIR ONLINE hari ini. Silakan check-in presensi ustadz terlebih dahulu.');
            }
        }

        $notesArray   = $request->input('notes', []);
        $substituteId = ($perm['is_substitute']) ? $ustadz->id : null;

        foreach ($validated['status'] as $santriId => $status) {
            $existing = SantriAttendance::where('santri_id', $santriId)
                ->whereDate('date', $dateFormatted)
                ->first();

            $data = [
                'class_id'             => $validated['class_id'],
                'status'               => $status,
                'recorded_by'          => $ustadz->id,
                'substitute_ustadz_id' => $substituteId,
                'notes'                => $notesArray[$santriId] ?? null,
            ];

            if ($existing) {
                $existing->update($data);
            } else {
                SantriAttendance::create(array_merge($data, [
                    'santri_id' => $santriId,
                    'date'      => $dateFormatted,
                ]));
            }
        }

        $className = $sqrClass?->name ?? 'Kelas';
        $dateLabel = Carbon::parse($dateFormatted)->translatedFormat('d F Y');
        $subNote   = $substituteId ? ' (Dicatat oleh Ustadz Pengganti)' : '';

        return back()->with('success', "✅ Presensi santri {$className} tanggal {$dateLabel} berhasil disimpan!{$subNote}");
    }

    public function santriList(SqrClass $class)
    {
        $santri = $class->activeSantri()->get();
        return response()->json($santri);
    }

    public function santriListByDate(SqrClass $class, $date)
    {
        $dateFormatted = Carbon::parse($date)->format('Y-m-d');
        $santriList    = $class->activeSantri()->get();
        $currentUser   = auth()->user();

        // Get existing attendance for this class and date
        $attendances = SantriAttendance::with(['recordedBy', 'substituteUstadz'])
            ->where('class_id', $class->id)
            ->whereDate('date', $dateFormatted)
            ->get()
            ->keyBy('santri_id');

        $perm = $this->resolveClassPermission($class, $dateFormatted, $currentUser);

        $recordedByFirst = $attendances->first()?->recordedBy;
        $substituteFirst = $attendances->first()?->substituteUstadz;

        $result = $santriList->map(function ($santri) use ($attendances) {
            $existing = $attendances->get($santri->id);
            return [
                'id'         => $santri->id,
                'full_name'  => $santri->full_name,
                'status'     => $existing ? $existing->status : 'Hadir',
                'notes'      => $existing ? $existing->notes : '',
                'has_record' => !is_null($existing),
            ];
        });

        $subName = $perm['substitute_user']?->formatted_name ?? ($substituteFirst ? $substituteFirst->formatted_name : null);

        return response()->json([
            'class_id'            => $class->id,
            'class_name'          => $class->name,
            'date'                => $dateFormatted,
            'date_human'          => Carbon::parse($dateFormatted)->format('d M Y'),
            'has_data'            => $attendances->isNotEmpty(),
            'can_record'          => $perm['can_record'],
            'cannot_record_reason'=> $perm['reason'],
            'is_auto_substitute'  => $perm['is_auto_substitute'],
            'main_ustadz_id'      => $perm['main_ustadz']?->id,
            'main_ustadz_name'    => $perm['main_ustadz']?->formatted_name ?? 'Belum Ditentukan',
            'main_ustadz_status'  => $perm['main_attendance']?->status ?? 'Belum Presensi',
            'main_ustadz_notes'   => $perm['main_attendance']?->notes ?? null,
            'recorded_by_name'    => $recordedByFirst?->formatted_name ?? null,
            'substitute_ustadz'   => $subName,
            'santri'              => $result,
        ]);
    }

    /**
     * Resolve permissions, schedule window, auto-alpa, and auto-substitute assignment.
     */
    private function resolveClassPermission(SqrClass $class, string $dateFormatted, User $user): array
    {
        $isToday    = ($dateFormatted === today()->format('Y-m-d'));
        $isFuture   = ($dateFormatted > today()->format('Y-m-d'));
        $mainUstadz = $class->ustadz;
        $isAdmin    = $user->hasRole('admin');

        if ($isFuture) {
            return [
                'can_record'          => false,
                'reason'              => '⛔ Tidak dapat melakukan presensi untuk tanggal di masa mendatang (future date).',
                'is_substitute'       => false,
                'is_auto_substitute'  => false,
                'substitute_user'     => null,
                'main_ustadz'         => $mainUstadz,
                'main_attendance'     => null,
            ];
        }

        if (!$mainUstadz) {
            return [
                'can_record'          => false,
                'reason'              => '⛔ Kelas ini belum memiliki Ustadz Utama yang ditugaskan oleh Admin. Absensi santri dikunci.',
                'is_substitute'       => false,
                'is_auto_substitute'  => false,
                'substitute_user'     => null,
                'main_ustadz'         => null,
                'main_attendance'     => null,
            ];
        }

        // Fetch Main Ustadz attendance for this date
        $mainAttendance = UstadzAttendance::where('ustadz_id', $mainUstadz->id)
            ->whereDate('date', $dateFormatted)
            ->first();

        // If today and Main Ustadz has NOT checked in, check if past attendance_end_time (Batas Akhir Presensi Ustadz)
        if ($isToday && !$mainAttendance) {
            $attEndTime  = $class->attendance_end_time ?? '16:15';
            $currentTime = now()->format('H:i');
            if ($currentTime > $attEndTime) {
                // Auto-mark Main Ustadz as ALPA by system
                $mainAttendance = UstadzAttendance::create([
                    'ustadz_id'     => $mainUstadz->id,
                    'date'          => today(),
                    'status'        => 'Alpa',
                    'check_in_time' => now()->format('H:i:s'),
                    'notes'         => "Otomatis ALPA oleh sistem (melewati batas jam presensi ustadz {$attEndTime} WIB)",
                ]);
            }
        }

        // 1. Manually designated substitute by Main Ustadz (valid only for this 1 day)
        $designatedSubId = $mainAttendance?->substitute_ustadz_id;

        // 2. Smart Auto-Assign substitute if Main Ustadz is ALPA or (Izin/Sakit without substitute)
        // Strictly filter teachers who checked in HADIR today AT THE SAME BRANCH LOCATION!
        $autoSubId = null;
        $isAutoSub = false;
        if ($isToday && ($mainAttendance?->status === 'Alpa' || ($mainAttendance && in_array($mainAttendance->status, ['Izin', 'Sakit']) && !$designatedSubId))) {
            $branchLocationId = $class->location_id ?? ($mainUstadz?->location_id);

            $query = UstadzAttendance::whereDate('date', today())
                ->where('status', 'Hadir')
                ->where('ustadz_id', '!=', $mainUstadz->id);

            if ($branchLocationId) {
                $query->whereHas('ustadz', function ($q) use ($branchLocationId) {
                    $q->where('location_id', $branchLocationId);
                });
            }

            $hadirUstadzRecord = $query->first();

            // Fallback if no teacher from same branch, try any teacher who is Hadir today
            if (!$hadirUstadzRecord) {
                $hadirUstadzRecord = UstadzAttendance::whereDate('date', today())
                    ->where('status', 'Hadir')
                    ->where('ustadz_id', '!=', $mainUstadz->id)
                    ->first();
            }

            if ($hadirUstadzRecord) {
                $autoSubId = $hadirUstadzRecord->ustadz_id;
                $isAutoSub = true;
            }
        }

        $activeSubId   = $designatedSubId ?? $autoSubId;
        $activeSubUser = $activeSubId ? User::find($activeSubId) : null;

        // Fetch User's own attendance for this date (required to record santri)
        $userSelfAttendance = UstadzAttendance::where('ustadz_id', $user->id)
            ->whereDate('date', $dateFormatted)
            ->first();

        $userIsHadirToday = $isAdmin || ($userSelfAttendance && in_array($userSelfAttendance->status, ['Hadir', 'Hadir Online']));

        $isMain       = ($user->id === $mainUstadz->id);
        $isSubstitute = ($activeSubId && (int)$user->id === (int)$activeSubId);

        // A teacher can record if:
        // 1. Admin
        // 2. OR (Is Main Teacher AND User has checked in HADIR/HADIR ONLINE today)
        // 3. OR (Is Substitute Teacher AND User has checked in HADIR/HADIR ONLINE today)
        $canRecord = $isAdmin || ($isMain && $userIsHadirToday) || ($isSubstitute && $userIsHadirToday);

        $reason = null;
        if (!$canRecord) {
            if ($isMain && !$userIsHadirToday) {
                $statusStr = $userSelfAttendance ? $userSelfAttendance->status : 'Belum Check-In';
                if ($activeSubUser) {
                    $locName = $activeSubUser->location?->name ?? 'Cabang SQR';
                    $typeStr = $designatedSubId ? 'ditunjuk resmi oleh Anda' : "otomatis ditugaskan sistem (Ustadz HADIR di {$locName})";
                    $reason  = "⛔ Status presensi Anda hari ini adalah '{$statusStr}'. Hak absen kelas Anda hari ini telah dialihkan ke Ustadz Pengganti ({$typeStr}): {$activeSubUser->formatted_name}.";
                } else {
                    $reason  = "⛔ Presensi Santri Terkunci: Status presensi Anda hari ini adalah '{$statusStr}'. Anda wajib check-in HADIR / HADIR ONLINE terlebih dahulu sebelum mengabsen santri.";
                }
            } elseif ($isSubstitute && !$userIsHadirToday) {
                $reason = "⛔ Sebagai Ustadz Pengganti, Anda wajib check-in HADIR terlebih dahulu hari ini sebelum mengabsen santri.";
            } elseif ($activeSubUser) {
                $locName = $activeSubUser->location?->name ?? 'Cabang SQR';
                $typeStr = $designatedSubId ? 'ditunjuk resmi oleh Ustadz Utama' : "otomatis ditugaskan sistem (Ustadz HADIR di {$locName})";
                $reason  = "⛔ Anda tidak berhak mengabsen kelas ini hari ini. Ustadz Pengganti ({$typeStr}) adalah {$activeSubUser->formatted_name}.";
            } elseif ($mainAttendance?->status === 'Alpa') {
                $reason  = "⛔ Pengampu kelas ini ({$mainUstadz->formatted_name}) dianggap ALPA oleh sistem karena melewati batas jam presensi. Belum ada Ustadz/Ustadzah lain yang presensi HADIR di cabang ini.";
            } else {
                $reason  = "⛔ Anda bukan Pengampu Utama kelas ini ({$mainUstadz->formatted_name}) dan tidak ditunjuk sebagai Pengganti resmi pada tanggal ini.";
            }
        }

        return [
            'can_record'          => $canRecord,
            'reason'              => $reason,
            'is_substitute'       => ($isSubstitute && !$isMain),
            'is_auto_substitute'  => $isAutoSub,
            'substitute_user'     => $activeSubUser,
            'main_ustadz'         => $mainUstadz,
            'main_attendance'     => $mainAttendance,
        ];
    }

    public function exportExcel(Request $request)
    {
        $classId    = $request->get('class_id');
        $filterType = $request->get('filter_type');
        $filterDate = $request->get('filter_date');
        $startDate  = $request->get('start_date');
        $endDate    = $request->get('end_date');
        $month      = $request->get('month');
        $year       = $request->get('year');

        $sqrClass = $classId ? SqrClass::find($classId) : null;
        $query    = SantriAttendance::with(['santri', 'sqrClass', 'recordedBy', 'substituteUstadz']);

        if ($classId) {
            $query->where('class_id', $classId);
        }

        $periodText = "";
        if ($filterType === 'single' && $filterDate) {
            $query->whereDate('date', $filterDate);
            $dateLabel  = "Tanggal_" . Carbon::parse($filterDate)->format('Ymd');
            $periodText = Carbon::parse($filterDate)->translatedFormat('d F Y');
        } elseif (($filterType === 'range' || !$filterType) && $startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
            $dateLabel  = "Periode_" . Carbon::parse($startDate)->format('Ymd') . "_s.d_" . Carbon::parse($endDate)->format('Ymd');
            $periodText = Carbon::parse($startDate)->translatedFormat('d F Y') . " s.d. " . Carbon::parse($endDate)->translatedFormat('d F Y');
        } elseif ($filterDate) {
            $query->whereDate('date', $filterDate);
            $dateLabel  = "Tanggal_" . Carbon::parse($filterDate)->format('Ymd');
            $periodText = Carbon::parse($filterDate)->translatedFormat('d F Y');
        } else {
            $m = $month ?? today()->month;
            $y = $year ?? today()->year;
            $query->whereMonth('date', $m)->whereYear('date', $y);
            $dateLabel  = "Bulan_{$y}-{$m}";
            $periodText = Carbon::create($y, (int)$m)->translatedFormat('F Y');
        }

        $records = $query->orderBy('date', 'asc')->orderBy('santri_id', 'asc')->get();

        $classNameSlug = $sqrClass ? Str::slug($sqrClass->name) . "_" : "";
        $filename      = "Rekap_Absensi_SQR_{$classNameSlug}{$dateLabel}.xls";

        $html = view('exports.attendance_excel', [
            'records'    => $records,
            'sqrClass'   => $sqrClass,
            'periodText' => $periodText,
            'printedAt'  => now()->translatedFormat('d F Y H:i'),
        ])->render();

        return response($html, 200, [
            "Content-Type"        => "application/vnd.ms-excel; charset=utf-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ]);
    }
}
