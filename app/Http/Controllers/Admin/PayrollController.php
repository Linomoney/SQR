<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolSchedule;
use App\Models\User;
use App\Models\UstadzAttendance;
use App\Models\UstadzPayrollBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year  = (int) $request->get('year', date('Y'));

        $rateFisik      = SchoolSchedule::rateHadirFisik();
        $rateOnline     = SchoolSchedule::rateHadirOnline();
        $rateSubstitute = SchoolSchedule::rateSubstituteBonus();
        $sqrLat         = SchoolSchedule::sqrLatitude();
        $sqrLng         = SchoolSchedule::sqrLongitude();
        $sqrRadius      = SchoolSchedule::sqrRadiusMeters();

        $allUstadz = User::role('ustadz')->where('is_active', true)->get();

        $bonuses = UstadzPayrollBonus::where('month', $month)
            ->where('year', $year)
            ->get()
            ->keyBy('ustadz_id');

        $locations = \App\Models\SqrLocation::where('is_active', true)->get();

        $payrollData = $allUstadz->map(function ($u) use ($month, $year, $rateFisik, $rateOnline, $rateSubstitute, $bonuses) {
            $attendances = UstadzAttendance::where('ustadz_id', $u->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $hadirFisikCount  = $attendances->where('status', 'Hadir')->count();
            $hadirOnlineCount = $attendances->where('status', 'Hadir Online')->count();
            $izinCount        = $attendances->where('status', 'Izin')->count();
            $sakitCount       = $attendances->where('status', 'Sakit')->count();
            $alpaCount        = $attendances->where('status', 'Alpa')->count();

            $substituteCount  = UstadzAttendance::where('substitute_ustadz_id', $u->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->count();

            $totalFisikPay    = $hadirFisikCount * $rateFisik;
            $totalOnlinePay   = $hadirOnlineCount * $rateOnline;
            $totalSubPay      = $substituteCount * $rateSubstitute;

            $bonusObj         = $bonuses->get($u->id);
            $bonusAmount      = $bonusObj ? (float)$bonusObj->bonus_amount : 0;
            $bonusNote        = $bonusObj ? $bonusObj->bonus_note : '';

            $grandTotal       = $totalFisikPay + $totalOnlinePay + $totalSubPay + $bonusAmount;

            return [
                'ustadz'               => $u,
                'location_name'        => $u->location?->name ?? 'SQR Utama Sukatani',
                'hadir_fisik'          => $hadirFisikCount,
                'hadir_online'         => $hadirOnlineCount,
                'izin'                 => $izinCount,
                'sakit'                => $sakitCount,
                'alpa'                 => $alpaCount,
                'substitute_count'     => $substituteCount,
                'total_fisik_pay'      => $totalFisikPay,
                'total_online_pay'     => $totalOnlinePay,
                'total_sub_pay'        => $totalSubPay,
                'bonus_amount'         => $bonusAmount,
                'bonus_note'           => $bonusNote,
                'grand_total'          => $grandTotal,
            ];
        });

        $totalPayrollBudget = $payrollData->sum('grand_total');

        return view('admin.payroll.index', compact(
            'month', 'year', 'rateFisik', 'rateOnline', 'rateSubstitute',
            'sqrLat', 'sqrLng', 'sqrRadius', 'payrollData', 'totalPayrollBudget', 'allUstadz', 'locations'
        ));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'rate_hadir_fisik'      => 'required|numeric|min:0',
            'rate_hadir_online'     => 'required|numeric|min:0',
            'rate_substitute_bonus' => 'required|numeric|min:0',
            'sqr_lat'               => 'required|numeric',
            'sqr_lng'               => 'required|numeric',
            'sqr_radius_meters'     => 'required|integer|min:10|max:5000',
        ]);

        SchoolSchedule::setSetting('rate_hadir_fisik', $validated['rate_hadir_fisik']);
        SchoolSchedule::setSetting('rate_hadir_online', $validated['rate_hadir_online']);
        SchoolSchedule::setSetting('rate_substitute_bonus', $validated['rate_substitute_bonus']);
        SchoolSchedule::setSetting('sqr_lat', $validated['sqr_lat']);
        SchoolSchedule::setSetting('sqr_lng', $validated['sqr_lng']);
        SchoolSchedule::setSetting('sqr_radius_meters', $validated['sqr_radius_meters']);

        return back()->with('success', '✅ Pengaturan tarif penggajian & koordinat GPS lokasi SQR berhasil disimpan!');
    }

    public function storeBonus(Request $request)
    {
        $validated = $request->validate([
            'ustadz_id'    => 'required|exists:users,id',
            'month'        => 'required|integer|min:1|max:12',
            'year'         => 'required|integer|min:2024|max:2030',
            'bonus_amount' => 'required|numeric|min:0',
            'bonus_note'   => 'nullable|string|max:255',
        ]);

        UstadzPayrollBonus::updateOrCreate(
            [
                'ustadz_id' => $validated['ustadz_id'],
                'month'     => $validated['month'],
                'year'      => $validated['year'],
            ],
            [
                'bonus_amount' => $validated['bonus_amount'],
                'bonus_note'   => $validated['bonus_note'] ?? null,
                'created_by'   => auth()->id(),
            ]
        );

        $ustadz = User::find($validated['ustadz_id']);
        return back()->with('success', "✅ Bonus penggajian untuk {$ustadz->formatted_name} berhasil disimpan!");
    }

    public function exportExcel(Request $request)
    {
        $month = (int) $request->get('month', date('m'));
        $year  = (int) $request->get('year', date('Y'));

        $rateFisik      = SchoolSchedule::rateHadirFisik();
        $rateOnline     = SchoolSchedule::rateHadirOnline();
        $rateSubstitute = SchoolSchedule::rateSubstituteBonus();

        $allUstadz = User::role('ustadz')->where('is_active', true)->get();
        $bonuses   = UstadzPayrollBonus::where('month', $month)->where('year', $year)->get()->keyBy('ustadz_id');

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $filename = "Rekap-Gaji-Ustadz-SQR-{$monthName}.csv";

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $callback = function () use ($allUstadz, $month, $year, $rateFisik, $rateOnline, $rateSubstitute, $bonuses, $monthName) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($file, ["REKAPITULASI PENGGAJIAN USTADZ & USTADZAH"]);
            fputcsv($file, ["SAUNG QURAN RABBANI — PERIODE {$monthName}"]);
            fputcsv($file, ["Tarif Hadir Fisik: Rp " . number_format($rateFisik, 0, ',', '.') . " | Tarif Hadir Online: Rp " . number_format($rateOnline, 0, ',', '.') . " | Insentif Pengganti: Rp " . number_format($rateSubstitute, 0, ',', '.')]);
            fputcsv($file, []);

            fputcsv($file, [
                'No',
                'Nama Ustadz/Ustadzah',
                'Cabang SQR Tempat Mengajar',
                'Email',
                'Hadir Fisik (Hari)',
                'Hadir Online (Hari)',
                'Tugas Pengganti (Sesi)',
                'Gaji Hadir Fisik (Rp)',
                'Gaji Hadir Online (Rp)',
                'Insentif Pengganti (Rp)',
                'Bonus/Tunjangan (Rp)',
                'Catatan Bonus',
                'TOTAL GAJI (Rp)',
            ]);

            $no = 1;
            $grandTotalAll = 0;

            foreach ($allUstadz as $u) {
                $attendances = UstadzAttendance::where('ustadz_id', $u->id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();

                $hadirFisikCount  = $attendances->where('status', 'Hadir')->count();
                $hadirOnlineCount = $attendances->where('status', 'Hadir Online')->count();

                $substituteCount  = UstadzAttendance::where('substitute_ustadz_id', $u->id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->count();

                $totalFisikPay  = $hadirFisikCount * $rateFisik;
                $totalOnlinePay = $hadirOnlineCount * $rateOnline;
                $totalSubPay    = $substituteCount * $rateSubstitute;

                $bonusObj    = $bonuses->get($u->id);
                $bonusAmount = $bonusObj ? (float)$bonusObj->bonus_amount : 0;
                $bonusNote   = $bonusObj ? $bonusObj->bonus_note : '-';

                $totalGaji   = $totalFisikPay + $totalOnlinePay + $totalSubPay + $bonusAmount;
                $grandTotalAll += $totalGaji;

                fputcsv($file, [
                    $no++,
                    $u->formatted_name,
                    $u->location?->name ?? 'SQR Utama Sukatani',
                    $u->email,
                    $hadirFisikCount,
                    $hadirOnlineCount,
                    $substituteCount,
                    number_format($totalFisikPay, 0, ',', '.'),
                    number_format($totalOnlinePay, 0, ',', '.'),
                    number_format($totalSubPay, 0, ',', '.'),
                    number_format($bonusAmount, 0, ',', '.'),
                    $bonusNote,
                    number_format($totalGaji, 0, ',', '.'),
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['', '', '', '', '', '', '', '', '', '', 'TOTAL ANGGARAN PENGGAJIAN', number_format($grandTotalAll, 0, ',', '.')]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
