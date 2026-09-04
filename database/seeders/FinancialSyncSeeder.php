<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\Santri;
use App\Models\User;

class FinancialSyncSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Sample Manual Incomes
        Income::firstOrCreate(['title' => 'Infaq Kotak Jumat Berkah SQR'], [
            'amount'      => 750000,
            'date'        => now()->subDays(2)->format('Y-m-d'),
            'description' => 'Hasil perolehan kotak infaq jamaah Jumat',
        ]);
        Income::firstOrCreate(['title' => 'Hamba Allah - Ta\'awun Operasional SQR'], [
            'amount'      => 1500000,
            'date'        => now()->subDays(5)->format('Y-m-d'),
            'description' => 'Transfer ta\'awun donatur tetap bulanan',
        ]);

        // 2. Seed Sample Manual Expenses
        Expense::firstOrCreate(['title' => 'Snack & Konsumsi Pengajian Wali Santri'], [
            'category'    => 'Konsumsi & Acara',
            'amount'      => 350000,
            'date'        => now()->subDays(3)->format('Y-m-d'),
            'description' => 'Pembelian kue & minuman kajian bulanan',
        ]);
        Expense::firstOrCreate(['title' => 'Program Jumat Berbagi - Paket Nasi Berkah'], [
            'category'    => 'Program Sosial & Sumbangan',
            'amount'      => 500000,
            'date'        => now()->subDays(6)->format('Y-m-d'),
            'description' => 'Pembagian 50 paket nasi bungkus untuk warga sekitar SQR',
        ]);
        Expense::firstOrCreate(['title' => 'Hadiah & Sertifikat Lomba Hafalan Santri'], [
            'category'    => 'Kegiatan Santri',
            'amount'      => 450000,
            'date'        => now()->subDays(10)->format('Y-m-d'),
            'description' => 'Piala & bingkisan santri berprestasi',
        ]);

        // 3. Seed Sample Campaign & Donations
        $campaign = Campaign::firstOrCreate(
            ['slug' => 'pembangunan-ruang-kelas-tahfidz-sqr'],
            [
                'title'          => 'Pembangunan Ruang Kelas Tahfidz SQR Utama',
                'category'       => 'Pembangunan & Fasilitas',
                'target_amount'  => 50000000,
                'current_amount' => 12500000,
                'excerpt'        => 'Bantu wujudkan kelas nyaman untuk para penghafal Al-Quran.',
                'description'    => 'Program renovasi dan penambahan 2 ruang kelas belajar santri.',
                'image_url'      => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop',
                'bank_name'      => 'Bank Syariah Indonesia (BSI)',
                'bank_account'   => '7289-0123-45',
                'bank_holder'    => 'Yayasan Bina Cahaya Ilmu Rabbani',
                'is_active'      => true,
            ]
        );

        $donations = [
            ['name' => 'H. Abdullah', 'amount' => 5000000, 'method' => 'Transfer BSI', 'notes' => 'Wakaf tunai semen & bata'],
            ['name' => 'Hj. Siti Rahmah', 'amount' => 2500000, 'method' => 'Transfer Mandiri', 'notes' => 'Donasi fasilitas meja santri'],
            ['name' => 'Bpk. Hendra Wijaya', 'amount' => 3000000, 'method' => 'QRIS Yayasan', 'notes' => 'Sedekah subuh pembangunan'],
            ['name' => 'Ibu Nurlaila', 'amount' => 2000000, 'method' => 'Transfer BSI', 'notes' => 'Infaq karpet kelas'],
        ];

        foreach ($donations as $d) {
            Donation::firstOrCreate(
                ['campaign_id' => $campaign->id, 'donor_name' => $d['name']],
                [
                    'donor_phone'    => '0812' . rand(10000000, 99999999),
                    'donor_email'    => strtolower(str_replace(' ', '', $d['name'])) . '@gmail.com',
                    'amount'         => $d['amount'],
                    'payment_method' => $d['method'],
                    'status'         => 'Paid',
                    'notes'          => $d['notes'],
                ]
            );
        }

        // Update campaign current amount
        $campaign->update(['current_amount' => Donation::where('campaign_id', $campaign->id)->where('status', 'Paid')->sum('amount')]);

        // 4. Seed Verified SPP Payments if santri exists
        $santri = Santri::first();
        if ($santri) {
            Payment::firstOrCreate(
                ['santri_id' => $santri->id, 'month_year' => 'Agustus 2026'],
                [
                    'amount' => 150000,
                    'status' => 'Verified',
                    'notes'  => 'Pembayaran SPP Syahriyah Agustus 2026',
                ]
            );
        }

        echo "✅ FinancialSyncSeeder completed: Manual Incomes, Manual Expenses, Campaign Donations & SPP Payments synced successfully!\n";
    }
}
