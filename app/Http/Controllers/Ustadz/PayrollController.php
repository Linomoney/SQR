<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\OrganizationSetting;
use App\Models\SchoolSchedule;
use App\Models\UstadzAttendance;
use App\Models\UstadzPayrollBonus;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $user  = auth()->user();
        $month = (int) $request->get('month', date('m'));
        $year  = (int) $request->get('year', date('Y'));

        $rateFisik      = SchoolSchedule::rateHadirFisik();
        $rateOnline     = SchoolSchedule::rateHadirOnline();
        $rateSubstitute = SchoolSchedule::rateSubstituteBonus();

        $attendances = UstadzAttendance::where('ustadz_id', $user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get();

        $hadirFisikCount  = $attendances->where('status', 'Hadir')->count();
        $hadirOnlineCount = $attendances->where('status', 'Hadir Online')->count();
        $izinCount        = $attendances->where('status', 'Izin')->count();
        $sakitCount       = $attendances->where('status', 'Sakit')->count();
        $alpaCount        = $attendances->where('status', 'Alpa')->count();

        $substituteCount  = UstadzAttendance::where('substitute_ustadz_id', $user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->count();

        $totalFisikPay  = $hadirFisikCount * $rateFisik;
        $totalOnlinePay = $hadirOnlineCount * $rateOnline;
        $totalSubPay    = $substituteCount * $rateSubstitute;

        $bonusObj       = UstadzPayrollBonus::where('ustadz_id', $user->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        $bonusAmount    = $bonusObj ? (float)$bonusObj->bonus_amount : 0;
        $bonusNote      = $bonusObj ? $bonusObj->bonus_note : null;

        $grandTotal     = $totalFisikPay + $totalOnlinePay + $totalSubPay + $bonusAmount;

        $orgSettings    = OrganizationSetting::getAllSettings();

        return view('ustadz.payroll.index', compact(
            'user', 'month', 'year', 'rateFisik', 'rateOnline', 'rateSubstitute',
            'attendances', 'hadirFisikCount', 'hadirOnlineCount', 'izinCount', 'sakitCount', 'alpaCount',
            'substituteCount', 'totalFisikPay', 'totalOnlinePay', 'totalSubPay',
            'bonusAmount', 'bonusNote', 'grandTotal', 'orgSettings'
        ));
    }

    public function downloadPdf(Request $request)
    {
        $user  = auth()->user();
        $month = (int) $request->get('month', date('m'));
        $year  = (int) $request->get('year', date('Y'));

        $rateFisik      = SchoolSchedule::rateHadirFisik();
        $rateOnline     = SchoolSchedule::rateHadirOnline();
        $rateSubstitute = SchoolSchedule::rateSubstituteBonus();

        $attendances = UstadzAttendance::where('ustadz_id', $user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $hadirFisikCount  = $attendances->where('status', 'Hadir')->count();
        $hadirOnlineCount = $attendances->where('status', 'Hadir Online')->count();

        $substituteCount  = UstadzAttendance::where('substitute_ustadz_id', $user->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->count();

        $totalFisikPay  = $hadirFisikCount * $rateFisik;
        $totalOnlinePay = $hadirOnlineCount * $rateOnline;
        $totalSubPay    = $substituteCount * $rateSubstitute;

        $bonusObj       = UstadzPayrollBonus::where('ustadz_id', $user->id)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        $bonusAmount    = $bonusObj ? (float)$bonusObj->bonus_amount : 0;
        $bonusNote      = $bonusObj ? $bonusObj->bonus_note : null;

        $grandTotal     = $totalFisikPay + $totalOnlinePay + $totalSubPay + $bonusAmount;

        $orgSettings     = OrganizationSetting::getAllSettingsForPdf();
        $monthName       = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $pimpinanSigUrl  = $orgSettings['pimpinan_signature_url'] ?? null;
        $pimpinanSigBase = OrganizationSetting::imageToBase64($pimpinanSigUrl);

        $pdf = Pdf::loadView('pdf.salary_slip', compact(
            'user', 'month', 'year', 'monthName', 'rateFisik', 'rateOnline', 'rateSubstitute',
            'hadirFisikCount', 'hadirOnlineCount', 'substituteCount',
            'totalFisikPay', 'totalOnlinePay', 'totalSubPay',
            'bonusAmount', 'bonusNote', 'grandTotal', 'orgSettings', 'pimpinanSigBase'
        ))
        ->setPaper('a5', 'landscape')
        ->setOption('dpi', 150)
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true);

        return $pdf->download("Slip-Gaji-SQR-{$user->name}-{$monthName}.pdf");
    }
}
