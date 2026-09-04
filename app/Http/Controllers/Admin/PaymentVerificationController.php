<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentVerification;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $verifications = PaymentVerification::with(['payment.santri', 'wali', 'verifiedBy'])
            ->latest()
            ->paginate(15);

        return view('admin.verifikasi.index', compact('verifications'));
    }

    public function approve(PaymentVerification $verification)
    {
        $verification->update([
            'status'      => 'Approved',
            'verified_by' => auth()->id(),
        ]);

        // Update parent payment status
        $verification->payment->update(['status' => 'Paid']);

        return back()->with('success', 'Verifikasi pembayaran berhasil disetujui.');
    }

    public function reject(Request $request, PaymentVerification $verification)
    {
        $request->validate([
            'notes' => 'required|string|max:255',
        ]);

        $verification->update([
            'status'      => 'Rejected',
            'verified_by' => auth()->id(),
            'notes'       => $request->notes,
        ]);

        $verification->payment->update(['status' => 'Pending']);

        return back()->with('success', 'Verifikasi pembayaran ditolak dengan alasan: ' . $request->notes);
    }
}
