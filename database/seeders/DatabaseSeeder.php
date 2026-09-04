<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Santri;
use App\Models\SqrClass;
use App\Models\Article;
use App\Models\Income;
use App\Models\Expense;
use App\Models\ContentManager;
use App\Models\Campaign;
use App\Models\Gallery;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $adminRole  = Role::firstOrCreate(['name' => 'admin']);
        $ustadzRole = Role::firstOrCreate(['name' => 'ustadz']);
        $waliRole   = Role::firstOrCreate(['name' => 'wali']);

        // 2. Main Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@sqr.id'],
            [
                'name'     => 'Admin Utama SQR',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('admin');

        $ustadz = User::firstOrCreate(
            ['email' => 'ustadz@sqr.id'],
            [
                'name'     => 'Ust. Ahmad Fauzi',
                'password' => bcrypt('password'),
            ]
        );
        $ustadz->assignRole('ustadz');

        $wali = User::firstOrCreate(
            ['email' => 'wali@sqr.id'],
            [
                'name'     => 'Bpk. Hendra Pratama',
                'password' => bcrypt('password'),
            ]
        );
        $wali->assignRole('wali');

        // 3. Kelas SQR
        $kelasAnak = SqrClass::firstOrCreate(
            ['class_name' => 'Kelas Anak (Ummi 1 - 6)'],
            ['description' => 'Kelas anak 5-12 thn', 'quota' => 30]
        );
        $kelasRemaja = SqrClass::firstOrCreate(
            ['class_name' => 'Kelas Remaja (Tahfidz Juz 30)'],
            ['description' => 'Kelas remaja 13-17 thn', 'quota' => 30]
        );
        $kelasDewasa = SqrClass::firstOrCreate(
            ['class_name' => 'Kelas Dewasa (Tahsin Al-Quran)'],
            ['description' => 'Kelas dewasa 18+ thn', 'quota' => 30]
        );

        // 4. Data Santri Contoh
        $santri1 = Santri::firstOrCreate(
            ['full_name' => 'Muhammad Rizki Pratama'],
            [
                'class_id'        => $kelasRemaja->id,
                'wali_user_id'   => $wali->id,
                'is_active'       => true,
                'gender'          => 'Laki-laki',
                'parent_name'     => 'Bpk. Hendra Pratama',
                'phone'           => '081293721163',
                'enrollment_date' => now()->subMonths(6),
            ]
        );

        // Add StudentProgress so santri1 has 30 Juz = 100% progress for certificate testing
        \App\Models\StudentProgress::firstOrCreate(
            ['santri_id' => $santri1->id, 'juz_end' => 30],
            [
                'ustadz_user_id'  => $ustadz->id,
                'type'            => 'Tahfiz',
                'juz_start'       => 1,
                'juz_end'         => 30,
                'surah_memorized' => 'An-Nas',
                'date'            => now(),
                'notes'           => '⭐ Predikat: Mumtaz (Sangat Lancar) | Lulus mutqin 30 Juz',
            ]
        );

        $santri2 = Santri::firstOrCreate(
            ['full_name' => 'Aisyah Az-Zahra'],
            [
                'class_id'        => $kelasAnak->id,
                'wali_user_id'   => $wali->id,
                'is_active'       => true,
                'gender'          => 'Perempuan',
                'parent_name'     => 'Bpk. Hendra Pratama',
                'phone'           => '081293721163',
                'enrollment_date' => now()->subMonths(3),
            ]
        );

        // 5. Initial Articles
        Article::firstOrCreate(
            ['slug' => 'metode-pembelajaran-ummi-jilid-1-xh7k'],
            [
                'title'        => 'Metode Pembelajaran Ummi Jilid 1',
                'category'     => 'Kegiatan',
                'excerpt'      => 'Panduan dasar pembelajaran Al-Quran dengan metode Ummi yang menyenangkan bagi santri anak-anak.',
                'content'      => 'Metode Ummi merupakan salah satu metode pembelajaran membaca Al-Quran yang berorientasi pada kualitas bacaan dan kemudahan pemahaman santri secara bertahap.',
                'media_url'    => 'https://youtu.be/SNRYDkaVrms?si=2DrIKGt6J1xw04wW',
                'is_published' => true,
                'author_id'    => $admin->id,
                'published_at' => now(),
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'persiapan-santri-menghadapi-ramadhan-1447h'],
            [
                'title'        => 'Persiapan Santri Menghadapi Ramadhan 1447H',
                'category'     => 'Kajian',
                'excerpt'      => 'Tips dan panduan menjaga hafalan Quran serta kedisiplinan beribadah di bulan suci Ramadhan.',
                'content'      => 'Bulan Ramadhan adalah momen emas bagi santri Saung Quran Rabbani untuk melipatgandakan muraja\'ah dan memperkuat target tahfidz.',
                'media_url'    => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=1200&auto=format&fit=crop',
                'is_published' => true,
                'author_id'    => $admin->id,
                'published_at' => now(),
            ]
        );

        // 6. Content Manager Entries
        ContentManager::firstOrCreate(['key' => 'home_tagline'], ['value' => 'Pondasi Quran Generasi Rabbani']);
        ContentManager::firstOrCreate(['key' => 'stat_total_santri'], ['value' => '150+']);
        ContentManager::firstOrCreate(['key' => 'stat_pengajar'], ['value' => '8+']);
        ContentManager::firstOrCreate(['key' => 'stat_tahun'], ['value' => '7th']);

        // 7. Seed Campaigns (SQR Berbagi Program)
        Campaign::firstOrCreate(
            ['slug' => 'jumat-berbagi-taawun-santri'],
            [
                'title'          => 'Program Jumat Berbagi & Ta\'awun Santri',
                'category'       => 'Program Rutin',
                'target_amount'  => 5000000.00,
                'current_amount' => 3750000.00,
                'excerpt'        => 'Penyediaan makanan bergizi & snack sehat setiap Jumat untuk santri usai kegiatan KBM Al-Quran.',
                'description'    => 'Program Jumat Berbagi dan Ta\'awun Santri bertujuan untuk menghadirkan kebahagiaan bagi para penghafal Al-Quran melalui hidangan Jumat berkah, bingkisan apresiasi hafalan, dan dukungan sarana belajar santri yatim & dhuafa.',
                'image_url'      => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop',
                'bank_name'      => 'Bank Syariah Indonesia (BSI)',
                'bank_account'   => '7289-0123-45',
                'bank_holder'    => 'Yayasan Bina Cahaya Ilmu Rabbani',
                'is_active'      => true,
                'end_date'       => now()->addDays(30),
            ]
        );

        Campaign::firstOrCreate(
            ['slug' => 'wakaf-100-al-quran-hafalan'],
            [
                'title'          => 'Wakaf 100 Mus-haf Al-Quran Hafalan Santri',
                'category'       => 'Wakaf Quran',
                'target_amount'  => 8500000.00,
                'current_amount' => 6200000.00,
                'excerpt'        => 'Pengadaan mus-haf hafalan standar Tajwid berwarna untuk santri baru Saung Quran Rabbani.',
                'description'    => 'Wakaf Al-Quran hafalan merupakan sedekah jariyah yang terus mengalirkan pahala setiap kali setiap ayat Al-Quran dibaca dan dihafal oleh para santri SQR.',
                'image_url'      => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=1200&auto=format&fit=crop',
                'bank_name'      => 'Bank Syariah Indonesia (BSI)',
                'bank_account'   => '7289-0123-45',
                'bank_holder'    => 'Yayasan Bina Cahaya Ilmu Rabbani',
                'is_active'      => true,
                'end_date'       => now()->addDays(45),
            ]
        );

        Campaign::firstOrCreate(
            ['slug' => 'renovasi-sarana-saung-quran'],
            [
                'title'          => 'Renovasi & Karpet Sajadah Saung Quran',
                'category'       => 'Fasilitas',
                'target_amount'  => 12000000.00,
                'current_amount' => 4500000.00,
                'excerpt'        => 'Pengadaan karpet tebal & perbaikan pendingin ruangan kelas belajar santri agar lebih khusyu\'.',
                'description'    => 'Kenyamanan tempat belajar Al-Quran sangat memengaruhi konsentrasi santri saat menghafal. Donasi ini digunakan untuk pembelian karpet empuk dan perbaikan pendingin ruangan kelas.',
                'image_url'      => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1200&auto=format&fit=crop',
                'bank_name'      => 'Bank Syariah Indonesia (BSI)',
                'bank_account'   => '7289-0123-45',
                'bank_holder'    => 'Yayasan Bina Cahaya Ilmu Rabbani',
                'is_active'      => true,
                'end_date'       => now()->addDays(60),
            ]
        );

        // 8. Seed Photo Gallery Items
        Gallery::firstOrCreate(
            ['title' => 'Kegiatan KBM Santri Ummi Jilid 1-6'],
            [
                'category'    => 'KBM Santri',
                'image_url'   => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Suasana bimbingan privat membaca Al-Quran santri anak usia dini dengan ustadz pengajar.',
                'event_date'  => now()->subDays(5),
                'is_featured' => true,
            ]
        );

        Gallery::firstOrCreate(
            ['title' => 'Setoran Hafalan Tahfidz Remaja'],
            [
                'category'    => 'KBM Santri',
                'image_url'   => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Proses ujian dan penyetoran hafalan mutqin Juz 30 oleh santri remaja SQR.',
                'event_date'  => now()->subDays(12),
                'is_featured' => true,
            ]
        );

        Gallery::firstOrCreate(
            ['title' => 'Penyaluran Paket Jumat Berbagi Santri'],
            [
                'category'    => 'Donasi',
                'image_url'   => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Pembagian snack sehat dan hidangan berkah untuk santri seusai shalat Jumat.',
                'event_date'  => now()->subDays(3),
                'is_featured' => true,
            ]
        );

        Gallery::firstOrCreate(
            ['title' => 'Sanlat Ramadhan & Mabit Santri'],
            [
                'category'    => 'Sanlat',
                'image_url'   => 'https://images.unsplash.com/photo-1519817650390-64a93db51149?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Kegiatan Pesantren Kilat Ramadhan dan Malam Bina Iman Taqwa (MABIT) santri SQR.',
                'event_date'  => now()->subDays(20),
                'is_featured' => true,
            ]
        );

        Gallery::firstOrCreate(
            ['title' => 'Kajian Tematik Parenting Quran'],
            [
                'category'    => 'Kajian',
                'image_url'   => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Kajian bulanan wali santri bersama ustadz pembina mengenai kurikulum pengajaran di rumah.',
                'event_date'  => now()->subDays(15),
                'is_featured' => true,
            ]
        );

        Gallery::firstOrCreate(
            ['title' => 'Wisuda & Haflah Akhir Sanah Tahfidz'],
            [
                'category'    => 'Wisuda',
                'image_url'   => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200&auto=format&fit=crop',
                'description' => 'Penyerahan sertifikat kelulusan dan penyerahan mahkota untuk orang tua santri mutqin.',
                'event_date'  => now()->subDays(30),
                'is_featured' => true,
            ]
        );

        // 8. Seed SPP Payments (100% Lunas Dummy)
        $this->call(SppPaymentSeeder::class);
    }
}
