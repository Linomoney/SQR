<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentVerification;
use App\Models\Santri;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user      = auth()->user();
        $mySantri  = $user->santriAsWali()->with('sqrClass')->get();
        $santriIds = $mySantri->pluck('id');

        $statusFilter = $request->query('status', 'all');
        $yearFilter   = $request->query('year', date('Y'));
        $santriFilter = $request->query('santri_id');

        // Query payments
        $query = Payment::with(['santri', 'verifications.verifiedBy', 'latestVerification'])
            ->whereIn('santri_id', $santriIds);

        if ($santriFilter) {
            $query->where('santri_id', $santriFilter);
        }

        if ($yearFilter) {
            $query->where('month_year', 'like', "{$yearFilter}-%");
        }

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', ucfirst($statusFilter));
        }

        $payments = $query->orderBy('month_year', 'desc')->paginate(12)->withQueryString();

        // 12-Month Matrix per Santri for selected year
        $monthlyMatrix = [];
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        foreach ($mySantri as $santri) {
            $santriMatrix = [];
            foreach ($months as $num => $name) {
                $monthYear = "{$yearFilter}-{$num}";
                $pay = Payment::where('santri_id', $santri->id)
                    ->where('month_year', $monthYear)
                    ->first();

                $santriMatrix[] = [
                    'month_num'  => $num,
                    'month_name' => $name,
                    'month_year' => $monthYear,
                    'status'     => $pay?->status ?? 'Unpaid',
                    'amount'     => $pay?->amount ?? 150000,
                    'payment'    => $pay,
                ];
            }
            $monthlyMatrix[] = [
                'santri' => $santri,
                'months' => $santriMatrix,
            ];
        }

        // Summary Stats
        $verifiedSum = Payment::whereIn('santri_id', $santriIds)
            ->where('status', 'Verified')
            ->where('month_year', 'like', "{$yearFilter}-%")
            ->sum('amount');

        $pendingCount = Payment::whereIn('santri_id', $santriIds)
            ->where('status', 'Pending')
            ->count();

        $isPortalLocked = $user->has_overdue_spp;

        return view('wali.payments.index', compact(
            'payments', 'mySantri', 'statusFilter', 'yearFilter',
            'santriFilter', 'monthlyMatrix', 'months',
            'verifiedSum', 'pendingCount', 'isPortalLocked'
        ));
    }

    public function uploadProof(Request $request)
    {
        $validated = $request->validate([
            'santri_id'  => 'required|exists:santri,id',
            'month_year' => 'required|string|regex:/^\d{4}-\d{2}$/',
            'amount'     => 'required|numeric|min:1000',
            'proof_url'  => 'required|url|max:500',
            'notes'      => 'nullable|string|max:500',
        ]);

        $santri = Santri::findOrFail($validated['santri_id']);

        if ($santri->wali_user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        // Upsert Payment
        $payment = Payment::updateOrCreate(
            [
                'santri_id'  => $santri->id,
                'month_year' => $validated['month_year'],
            ],
            [
                'amount' => $validated['amount'],
                'status' => 'Pending',
                'notes'  => $validated['notes'] ?? null,
            ]
        );

        // Record verification
        PaymentVerification::create([
            'payment_id'       => $payment->id,
            'wali_user_id'     => auth()->id(),
            'proof_image_path' => $validated['proof_url'],
            'status'           => 'Pending',
        ]);

        return back()->with('success', "✅ Bukti pembayaran SPP bulan {$validated['month_year']} atas nama {$santri->full_name} berhasil diunggah! Menunggu verifikasi admin.");
    }
}
