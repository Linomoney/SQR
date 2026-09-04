<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriAttendance;
use App\Models\SqrClass;
use App\Models\StudentProgress;
use App\Models\UstadzAttendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $ustadz = auth()->user();
        $sqrClass = $ustadz->sqrClass ?? SqrClass::where('is_active', true)->first();
        
        $santriQuery = Santri::where('is_active', true);
        if ($sqrClass) {
            $santriQuery->where('class_id', $sqrClass->id);
        }
        $santriCount = $santriQuery->count();

        // Santri list in class with their latest progress
        $classSantriList = $sqrClass 
            ? $sqrClass->activeSantri()->with(['studentProgress' => function($q) {
                $q->latest('date')->latest('id');
            }])->get()
            : collect();

        // Sort Top Performers by progress percentage
        $topSantriList = $classSantriList->sortByDesc(function($s) {
            return $s->progress_percentage;
        })->take(5);

        // Today's ustadz attendance check-in
        $todayAttendance = UstadzAttendance::where('ustadz_id', $ustadz->id)
            ->whereDate('date', today())
            ->first();

        // Total setoran entries by Ustadz this month
        $monthlySetoranQuery = StudentProgress::where('ustadz_user_id', $ustadz->id)
            ->whereMonth('date', today()->month)
            ->whereYear('date', today()->year);

        $monthlySetoranCount = (clone $monthlySetoranQuery)->count();
        $tahfizCount         = (clone $monthlySetoranQuery)->where('type', 'Tahfiz')->count();
        $murojaahCount       = (clone $monthlySetoranQuery)->where('type', 'Murojaah')->count();
        $tahsinCount         = (clone $monthlySetoranQuery)->where('type', 'Tahsin')->count();

        // Today's Santri attendance stats for class
        $todaySantriAttendances = $sqrClass
            ? SantriAttendance::where('class_id', $sqrClass->id)->whereDate('date', today())->get()
            : collect();
            
        $todaySantriHadirCount = $todaySantriAttendances->where('status', 'Hadir')->count();

        // Recent 10 progress entries by ustadz
        $recentProgress = StudentProgress::with(['santri', 'santri.sqrClass'])
            ->where('ustadz_user_id', $ustadz->id)
            ->latest('date')
            ->latest('id')
            ->limit(10)
            ->get();

        // ── Jadwal & Kalender Akademik ───────────────────────────────
        $todayEvents    = \App\Models\SchoolEvent::today()->orderBy('type')->get();
        $isSchoolDay    = \App\Models\SchoolSchedule::isSchoolDay(today());
        $jamMasuk       = \App\Models\SchoolSchedule::jamMasuk();
        $jamPulang      = \App\Models\SchoolSchedule::jamPulang();
        $upcomingEvents = \App\Models\SchoolEvent::upcoming(14)->get();

        return view('ustadz.dashboard', compact(
            'ustadz',
            'sqrClass',
            'santriCount',
            'classSantriList',
            'topSantriList',
            'todayAttendance',
            'monthlySetoranCount',
            'tahfizCount',
            'murojaahCount',
            'tahsinCount',
            'todaySantriHadirCount',
            'recentProgress',
            'todayEvents',
            'isSchoolDay',
            'jamMasuk',
            'jamPulang',
            'upcomingEvents'
        ));
    }
}
