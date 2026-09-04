<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolEvent;
use App\Models\SchoolSchedule;
use App\Models\SqrClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $year  = (int) $request->query('year', date('Y'));
        $month = (int) $request->query('month', date('n'));

        // Clamp month
        if ($month < 1) { $month = 12; $year--; }
        if ($month > 12) { $month = 1; $year++; }

        $settings  = SchoolSchedule::allSettings();
        $classes   = SqrClass::where('is_active', true)->get();

        // Events for the selected month
        $events = SchoolEvent::with(['sqrClass', 'creator'])
            ->forMonth($year, $month)
            ->orderBy('date')
            ->get();

        // Build calendar grid (days of the selected month)
        $calStart     = Carbon::create($year, $month, 1);
        $calEnd       = $calStart->copy()->endOfMonth();
        $weeklyOffDays = SchoolSchedule::weeklyOffDays();

        // Map events by date string for quick lookup
        $eventsByDate = [];
        foreach ($events as $event) {
            $d = $event->date instanceof Carbon ? $event->date : Carbon::parse($event->date);
            $e = $event->date_end ? ($event->date_end instanceof Carbon ? $event->date_end : Carbon::parse($event->date_end)) : $d->copy();
            
            $cursor = $d->copy();
            while ($cursor->lte($e)) {
                $key = $cursor->toDateString();
                $eventsByDate[$key][] = $event;
                $cursor->addDay();
            }
        }

        // Upcoming events for the next 30 days
        $upcomingEvents = SchoolEvent::with('sqrClass')
            ->upcoming(30)
            ->get();

        // Today's status
        $todayEvents  = SchoolEvent::with('sqrClass')->today()->get();
        $isSchoolDay  = SchoolSchedule::isSchoolDay(today());

        return view('admin.jadwal.index', compact(
            'year', 'month', 'settings', 'classes', 'events',
            'calStart', 'calEnd', 'weeklyOffDays', 'eventsByDate',
            'upcomingEvents', 'todayEvents', 'isSchoolDay'
        ));
    }

    public function publicView(Request $request)
    {
        $year  = (int) $request->query('year', date('Y'));
        $month = (int) $request->query('month', date('n'));

        if ($month < 1) { $month = 12; $year--; }
        if ($month > 12) { $month = 1; $year++; }

        $settings  = SchoolSchedule::allSettings();

        $events = SchoolEvent::with(['sqrClass'])
            ->forMonth($year, $month)
            ->orderBy('date')
            ->get();

        $calStart      = Carbon::create($year, $month, 1);
        $calEnd        = $calStart->copy()->endOfMonth();
        $weeklyOffDays = SchoolSchedule::weeklyOffDays();

        $eventsByDate = [];
        foreach ($events as $event) {
            $d = $event->date instanceof Carbon ? $event->date : Carbon::parse($event->date);
            $e = $event->date_end ? ($event->date_end instanceof Carbon ? $event->date_end : Carbon::parse($event->date_end)) : $d->copy();
            
            $cursor = $d->copy();
            while ($cursor->lte($e)) {
                $key = $cursor->toDateString();
                $eventsByDate[$key][] = $event;
                $cursor->addDay();
            }
        }

        $upcomingEvents = SchoolEvent::with('sqrClass')->upcoming(30)->get();
        $todayEvents    = SchoolEvent::with('sqrClass')->today()->get();
        $isSchoolDay    = SchoolSchedule::isSchoolDay(today());
        $jamMasuk       = SchoolSchedule::jamMasuk();
        $jamPulang      = SchoolSchedule::jamPulang();

        return view('public.kalender', compact(
            'year', 'month', 'settings', 'events',
            'calStart', 'calEnd', 'weeklyOffDays', 'eventsByDate',
            'upcomingEvents', 'todayEvents', 'isSchoolDay',
            'jamMasuk', 'jamPulang'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'              => 'required|date',
            'date_end'          => 'nullable|date|after_or_equal:date',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:1000',
            'type'              => 'required|in:libur,acara,pengumuman,online',
            'is_holiday'        => 'nullable|boolean',
            'online_link'       => 'nullable|url|max:500',
            'online_start_time' => 'nullable|date_format:H:i',
            'class_id'          => 'nullable|exists:classes,id',
        ]);

        if ($validated['type'] === 'libur') {
            $validated['is_holiday'] = true;
        }

        $validated['created_by'] = auth()->id();

        SchoolEvent::create($validated);

        return back()->with('success', "✅ Event '{$validated['title']}' berhasil ditambahkan ke kalender.");
    }

    public function update(Request $request, SchoolEvent $jadwal)
    {
        $validated = $request->validate([
            'date'              => 'required|date',
            'date_end'          => 'nullable|date|after_or_equal:date',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string|max:1000',
            'type'              => 'required|in:libur,acara,pengumuman,online',
            'is_holiday'        => 'nullable|boolean',
            'online_link'       => 'nullable|url|max:500',
            'online_start_time' => 'nullable|date_format:H:i',
            'class_id'          => 'nullable|exists:classes,id',
        ]);

        if ($validated['type'] === 'libur') {
            $validated['is_holiday'] = true;
        }

        $jadwal->update($validated);

        return back()->with('success', "✅ Event '{$jadwal->title}' berhasil diperbarui.");
    }

    public function destroy(SchoolEvent $jadwal)
    {
        $title = $jadwal->title;
        $jadwal->delete();
        return back()->with('success', "🗑️ Event '{$title}' berhasil dihapus dari kalender.");
    }

    public function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'jam_masuk'        => 'required|date_format:H:i',
            'jam_pulang'       => 'required|date_format:H:i|after:jam_masuk',
            'libur_mingguan'   => 'required|array',
            'libur_mingguan.*' => 'integer|between:0,6',
            'nama_sekolah'     => 'nullable|string|max:255',
        ]);

        $validated['libur_mingguan'] = implode(',', $validated['libur_mingguan']);

        foreach ($validated as $key => $value) {
            SchoolSchedule::setSetting($key, $value);
        }

        return back()->with('success', '✅ Pengaturan jam operasional & hari libur mingguan berhasil disimpan.');
    }

    public function apiEvents(Request $request, int $year, int $month)
    {
        $events = SchoolEvent::forMonth($year, $month)
            ->get(['id', 'date', 'date_end', 'title', 'type', 'is_holiday', 'online_link']);

        return response()->json([
            'events'          => $events,
            'weekly_off_days' => SchoolSchedule::weeklyOffDays(),
            'jam_masuk'       => SchoolSchedule::jamMasuk(),
            'jam_pulang'      => SchoolSchedule::jamPulang(),
        ]);
    }
}
