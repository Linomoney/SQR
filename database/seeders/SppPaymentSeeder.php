<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;
use App\Models\Payment;
use App\Models\PaymentVerification;
use App\Models\User;

class SppPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::role('admin')->first() ?? User::first();

        // Fetch all active santri
        $santris = Santri::where('is_active', true)->get();

        if ($santris->isEmpty()) {
            $this->command->info("Tidak ada santri aktif ditemukan untuk diseed pembayaran SPP.");
            return;
        }

        $years = [2025, 2026];
        $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $proofUrl = 'https://res.cloudinary.com/ddh5nkwv7/image/upload/v1787211352/ttd-removebg-preview_igneun.png';

        $totalSeeded = 0;

        foreach ($santris as $santri) {
            foreach ($years as $year) {
                foreach ($months as $month) {
                    $monthYear = "{$year}-{$month}";

                    // Upsert Payment record as Verified (Lunas)
                    $payment = Payment::updateOrCreate(
                        [
                            'santri_id'  => $santri->id,
                            'month_year' => $monthYear,
                        ],
                        [
                            'amount'     => 150000,
                            'status'     => 'Verified',
                            'notes'      => "SPP Lunas Otomatis Dummy - Bulan {$monthYear}",
                        ]
                    );

                    // Upsert PaymentVerification record
                    PaymentVerification::updateOrCreate(
                        [
                            'payment_id' => $payment->id,
                        ],
                        [
                            'wali_user_id'     => $santri->wali_user_id,
                            'proof_image_path' => $proofUrl,
                            'status'           => 'Verified',
                            'admin_notes'      => 'Pembayaran terverifikasi otomatis oleh sistem (Lunas)',
                            'verified_by'      => $adminUser?->id,
                            'verified_at'      => now(),
                        ]
                    );

                    $totalSeeded++;
                }
            }
        }

        $this->command->info("✅ Berhasil membuat {$totalSeeded} data transaksi SPP Lunas (Verified) untuk seluruh santri.");
    }
}
