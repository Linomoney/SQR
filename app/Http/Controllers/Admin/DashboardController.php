<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\Santri;
use App\Models\SqrClass;
use App\Models\User;
use App\Models\Payment;
use App\Models\Campaign;
use App\Models\SqrNotification;
use App\Models\SchoolEvent;
use App\Models\SchoolSchedule;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_santri'   => Santri::where('is_active', true)->count(),
            'total_ustadz'   => User::role('ustadz')->count(),
            'total_wali'     => User::role('wali')->count(),
            'total_kelas'    => SqrClass::where('is_active', true)->count(),
            'ppdb_pending'   => Ppdb::where('status', 'Pending')->count(),
            'ppdb_diterima'  => Ppdb::where('status', 'Diterima')->count(),
            'ppdb_total'     => Ppdb::count(),
            'spp_pending'    => Payment::where('status', 'Pending')->count(),
            'spp_lunas'      => Payment::where('status', 'Lunas')->count(),
        ];

        $recentPpdb    = Ppdb::with('kelasDiminati')->latest()->limit(5)->get();
        $classes       = SqrClass::withCount(['activeSantri'])->get();
        $campaigns     = Campaign::latest()->take(3)->get();
        $notifications = SqrNotification::forAdmin()->latest()->take(5)->get();

        // ── Jadwal & Kalender Data for Admin Dashboard ────────────────
        $todayEvents   = SchoolEvent::today()->orderBy('type')->get();
        $isSchoolDay   = SchoolSchedule::isSchoolDay(today());
        $jamMasuk      = SchoolSchedule::jamMasuk();
        $jamPulang     = SchoolSchedule::jamPulang();
        $weeklyOffDays = SchoolSchedule::weeklyOffDays();

        // Next 7 days strip
        $next7Days = collect();
        for ($i = 0; $i < 7; $i++) {
            $d = today()->addDays($i);
            $events = SchoolEvent::onDate($d)->get();
            $isOff  = in_array($d->dayOfWeek, $weeklyOffDays);
            $hasHoliday = $events->where('is_holiday', true)->count() > 0;
            $next7Days->push([
                'date'       => $d,
                'events'     => $events,
                'is_off'     => $isOff,
                'has_holiday'=> $hasHoliday,
                'is_school'  => !$isOff && !$hasHoliday,
                'is_today'   => $i === 0,
            ]);
        }

        $upcomingEvents = SchoolEvent::upcoming(14)->get();

        return view('admin.dashboard', compact(
            'stats', 'recentPpdb', 'classes', 'campaigns', 'notifications',
            'todayEvents', 'isSchoolDay', 'jamMasuk', 'jamPulang',
            'next7Days', 'upcomingEvents'
        ));
    }
}
