<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get Wali's active santri
        $santriList = Santri::where('wali_user_id', $user->id)
            ->where('is_active', true)
            ->get();

        if ($santriList->isEmpty()) {
            // Fallback for demo or admin
            $santriList = Santri::where('is_active', true)->take(5)->get();
        }

        $selectedSantriId = (int) $request->get('santri_id', $santriList->first()?->id);
        $selectedSantri   = Santri::find($selectedSantriId);

        $month = (int) $request->get('month', date('m'));
        $year  = (int) $request->get('year', date('Y'));

        $attendances = collect();
        $stats = [
            'total_days' => 0,
            'hadir'      => 0,
            'izin'       => 0,
            'sakit'      => 0,
            'alpa'       => 0,
            'percentage' => 100,
        ];

        if ($selectedSantri) {
            $attendances = SantriAttendance::with(['sqrClass', 'recordedBy', 'substituteUstadz'])
                ->where('santri_id', $selectedSantri->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->orderBy('date', 'desc')
                ->get();

            $total = $attendances->count();
            $hadir = $attendances->where('status', 'Hadir')->count();
            $izin  = $attendances->where('status', 'Izin')->count();
            $sakit = $attendances->where('status', 'Sakit')->count();
            $alpa  = $attendances->where('status', 'Alpa')->count();

            $stats = [
                'total_days' => $total,
                'hadir'      => $hadir,
                'izin'       => $izin,
                'sakit'      => $sakit,
                'alpa'       => $alpa,
                'percentage' => $total > 0 ? round(($hadir / $total) * 100) : 100,
            ];
        }

        return view('wali.attendance.index', compact(
            'santriList', 'selectedSantri', 'selectedSantriId',
            'month', 'year', 'attendances', 'stats'
        ));
    }
}
