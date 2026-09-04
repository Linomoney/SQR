<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Donation;
use App\Models\UstadzAttendance;
use App\Models\UstadzPayrollBonus;
use App\Models\SchoolSchedule;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $incomes  = Income::latest()->paginate(10, ['*'], 'incomes_page');
        $expenses = Expense::latest()->paginate(10, ['*'], 'expenses_page');

        $manualIncome   = Income::sum('amount');
        $sppIncome      = Payment::whereIn('status', ['Paid', 'Verified'])->sum('amount');
        $donationIncome = Donation::where('status', 'Paid')->sum('amount');
        $totalIncome    = $manualIncome + $sppIncome + $donationIncome;

        $manualExpense  = Expense::sum('amount');
        $payrollExpense = $this->calculateTotalPayrollExpense();
        $totalExpense   = $manualExpense + $payrollExpense;

        $balance = $totalIncome - $totalExpense;

        return view('admin.finance.index', compact(
            'incomes',
            'expenses',
            'manualIncome',
            'sppIncome',
            'donationIncome',
            'totalIncome',
            'manualExpense',
            'payrollExpense',
            'totalExpense',
            'balance'
        ));
    }

    private function calculateTotalPayrollExpense(): float
    {
        $dailyRateHadir  = (float) SchoolSchedule::rateHadirFisik();
        $dailyRateOnline = (float) SchoolSchedule::rateHadirOnline();

        $hadirCount  = UstadzAttendance::where('status', 'Hadir')->count();
        $onlineCount = UstadzAttendance::where('status', 'Hadir Online')->count();

        $attendanceFee = ($hadirCount * $dailyRateHadir) + ($onlineCount * $dailyRateOnline);
        $totalBonuses  = UstadzPayrollBonus::sum('amount');

        return $attendanceFee + $totalBonuses;
    }

    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'source'      => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        Income::create([
            'title'       => $validated['source'],
            'amount'      => $validated['amount'],
            'date'        => $validated['date'],
            'description' => $validated['description'] ?? null,
            'recorded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Pemasukan berhasil dicatat.');
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'category'    => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        Expense::create([
            'title'       => $validated['category'],
            'category'    => $validated['category'],
            'amount'      => $validated['amount'],
            'date'        => $validated['date'],
            'description' => $validated['description'] ?? null,
            'recorded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function destroyIncome(Income $income)
    {
        $income->delete();
        return back()->with('success', 'Catatan pemasukan telah dihapus.');
    }

    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Catatan pengeluaran telah dihapus.');
    }

    public function exportExcel()
    {
        $fileName = 'Laporan_Keuangan_SQR_' . date('Y_m_d_His') . '.csv';

        $manualIncome   = Income::sum('amount');
        $sppIncome      = Payment::whereIn('status', ['Paid', 'Verified'])->sum('amount');
        $donationIncome = Donation::where('status', 'Paid')->sum('amount');
        $totalIncome    = $manualIncome + $sppIncome + $donationIncome;

        $manualExpense  = Expense::sum('amount');
        $payrollExpense = $this->calculateTotalPayrollExpense();
        $totalExpense   = $manualExpense + $payrollExpense;
        $balance        = $totalIncome - $totalExpense;

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$fileName}\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($manualIncome, $sppIncome, $donationIncome, $totalIncome, $manualExpense, $payrollExpense, $totalExpense, $balance) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, ['REKAPITULASI LAPORAN KEUANGAN & SALDO KAS YAYASAN SQR']);
            fputcsv($file, ['Tanggal Cetak: ' . date('d F Y H:i:s')]);
            fputcsv($file, []);

            // Summary Section
            fputcsv($file, ['SUMBER PEMASUKAN', 'JUMLAH (RP)']);
            fputcsv($file, ['Infaq / Donasi / Ta\'awun Manual', number_format($manualIncome, 0, ',', '.')]);
            fputcsv($file, ['Pemasukan SPP Syahriyah Santri', number_format($sppIncome, 0, ',', '.')]);
            fputcsv($file, ['Pemasukan Donasi Program Campaign', number_format($donationIncome, 0, ',', '.')]);
            fputcsv($file, ['TOTAL PEMASUKAN', number_format($totalIncome, 0, ',', '.')]);
            fputcsv($file, []);

            fputcsv($file, ['KATEGORI PENGELUARAN', 'JUMLAH (RP)']);
            fputcsv($file, ['Pengeluaran Operasional & Program Jumat Berbagi (Manual)', number_format($manualExpense, 0, ',', '.')]);
            fputcsv($file, ['Pengeluaran Honor & Penggajian Ustadz', number_format($payrollExpense, 0, ',', '.')]);
            fputcsv($file, ['TOTAL PENGELUARAN', number_format($totalExpense, 0, ',', '.')]);
            fputcsv($file, []);

            fputcsv($file, ['SISA SALDO KAS BERSIH SQR', number_format($balance, 0, ',', '.')]);
            fputcsv($file, []);

            // Income detail log
            fputcsv($file, ['DETAIL TRANSAKSI PEMASUKAN']);
            fputcsv($file, ['NO', 'TANGGAL', 'SUMBER / DEKSRIPSI', 'KATEGORI', 'JUMLAH (RP)']);
            $no = 1;
            foreach (Income::latest()->get() as $inc) {
                fputcsv($file, [
                    $no++,
                    $inc->date ? $inc->date->format('d/m/Y') : '-',
                    $inc->title,
                    'Manual Income',
                    number_format($inc->amount, 0, ',', '.')
                ]);
            }
            foreach (Donation::where('status', 'Paid')->with('campaign')->get() as $don) {
                fputcsv($file, [
                    $no++,
                    $don->created_at->format('d/m/Y'),
                    'Donasi: ' . $don->donor_name . ' (' . ($don->campaign?->title ?? 'Campaign') . ')',
                    'Donasi Campaign',
                    number_format($don->amount, 0, ',', '.')
                ]);
            }
            fputcsv($file, []);

            // Expense detail log
            fputcsv($file, ['DETAIL TRANSAKSI PENGELUARAN']);
            fputcsv($file, ['NO', 'TANGGAL', 'KATEGORI / DESKRIPSI', 'JENIS', 'JUMLAH (RP)']);
            $noExp = 1;
            foreach (Expense::latest()->get() as $exp) {
                fputcsv($file, [
                    $noExp++,
                    $exp->date ? $exp->date->format('d/m/Y') : '-',
                    $exp->title ?? $exp->category,
                    'Manual Expense',
                    number_format($exp->amount, 0, ',', '.')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
