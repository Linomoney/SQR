<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns       = Campaign::withCount('donations')->latest()->get();
        $totalCollected  = Donation::where('status', 'Paid')->sum('amount');
        $totalDonors     = Donation::where('status', 'Paid')->count();
        $totalCampaigns  = Campaign::count();
        $donationLogs    = Donation::with('campaign')->latest()->paginate(15, ['*'], 'donations_page');

        return view('admin.campaigns.index', compact(
            'campaigns',
            'totalCollected',
            'totalDonors',
            'totalCampaigns',
            'donationLogs'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'category'       => 'nullable|string|max:100',
            'target_amount'  => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'excerpt'        => 'nullable|string',
            'description'    => 'nullable|string',
            'image_url'      => 'nullable|url',
            'bank_name'      => 'nullable|string|max:255',
            'bank_account'   => 'nullable|string|max:255',
            'bank_holder'    => 'nullable|string|max:255',
        ]);

        Campaign::create([
            'title'          => $request->title,
            'slug'           => Str::slug($request->title) . '-' . Str::random(4),
            'category'       => $request->category ?? 'Program Donasi',
            'target_amount'  => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0,
            'excerpt'        => $request->excerpt,
            'description'    => $request->description,
            'image_url'      => $request->image_url ?? 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop',
            'bank_name'      => $request->bank_name ?? 'Bank Syariah Indonesia (BSI)',
            'bank_account'   => $request->bank_account ?? '7289-0123-45',
            'bank_holder'    => $request->bank_holder ?? 'Yayasan Bina Cahaya Ilmu Rabbani',
            'is_active'      => true,
            'end_date'       => $request->end_date ?? now()->addDays(30),
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Program Campaign Donasi berhasil ditambahkan!');
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'target_amount'  => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
        ]);

        $campaign->update([
            'title'          => $request->title,
            'category'       => $request->category ?? $campaign->category,
            'target_amount'  => $request->target_amount,
            'current_amount' => $request->current_amount,
            'excerpt'        => $request->excerpt ?? $campaign->excerpt,
            'description'    => $request->description ?? $campaign->description,
            'image_url'      => $request->image_url ?? $campaign->image_url,
            'bank_name'      => $request->bank_name ?? $campaign->bank_name,
            'bank_account'   => $request->bank_account ?? $campaign->bank_account,
            'bank_holder'    => $request->bank_holder ?? $campaign->bank_holder,
            'is_active'      => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Program Donasi berhasil diperbarui!');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('admin.campaigns.index')->with('success', 'Program Donasi berhasil dihapus!');
    }

    public function exportDonationsExcel()
    {
        $fileName = 'Rekap_Donasi_Campaign_SQR_' . date('Y_m_d_His') . '.csv';

        $totalCollected = Donation::where('status', 'Paid')->sum('amount');
        $totalDonors    = Donation::where('status', 'Paid')->count();

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$fileName}\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($totalCollected, $totalDonors) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM

            fputcsv($file, ['REKAPITULASI LOG TRANSAKSI DONASI CAMPAIGN SQR']);
            fputcsv($file, ['Tanggal Ekspor: ' . date('d F Y H:i:s')]);
            fputcsv($file, ['Total Donasi Terkumpul: Rp ' . number_format($totalCollected, 0, ',', '.')]);
            fputcsv($file, ['Total Transaksi Donatur: ' . $totalDonors . ' Transaksi']);
            fputcsv($file, []);

            fputcsv($file, ['NO', 'TANGGAL', 'NAMA DONATUR', 'EMAIL / NO HP', 'PROGRAM CAMPAIGN', 'JUMLAH DONASI (RP)', 'METODE PEMBAYARAN', 'STATUS', 'CATATAN / WAKAF']);

            $no = 1;
            foreach (Donation::with('campaign')->latest()->get() as $don) {
                fputcsv($file, [
                    $no++,
                    $don->created_at->format('d/m/Y H:i'),
                    $don->donor_name,
                    $don->donor_phone ?? $don->donor_email ?? '-',
                    $don->campaign?->title ?? 'Program Umur',
                    number_format($don->amount, 0, ',', '.'),
                    $don->payment_method,
                    $don->status,
                    $don->notes ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
