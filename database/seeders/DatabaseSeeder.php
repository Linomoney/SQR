<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Santri;
use App\Models\SqrClass;
use App\Models\SqrLocation;
use App\Models\Article;
use App\Models\Income;
use App\Models\Expense;
use App\Models\ContentManager;
use App\Models\OrganizationSetting;
use App\Models\Campaign;
use App\Models\Gallery;
use App\Models\StudentProgress;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles & Permissions
        $adminRole  = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $ustadzRole = Role::firstOrCreate(['name' => 'ustadz', 'guard_name' => 'web']);
        $waliRole   = Role::firstOrCreate(['name' => 'wali', 'guard_name' => 'web']);

        // 2. Seed SQR Locations
        $locUtama = SqrLocation::firstOrCreate(
            ['code' => 'SQR-UTAMA'],
            [
                'name'           => 'SQR Utama (Sukatani, Tapos Depok)',
                'address'        => 'Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos Depok',
                'latitude'       => '-6.393733',
                'longitude'      => '106.878266',
                'radius_meters'  => 30,
                'is_active'      => true,
            ]
        );

        $locTapos = SqrLocation::firstOrCreate(
            ['code' => 'SQR-TAPOS'],
            [
                'name'           => 'SQR Cabang Tapos',
                'address'        => 'Jl. Raya Tapos No. 12, Tapos Depok',
                'latitude'       => '-6.402',
                'longitude'      => '106.882',
                'radius_meters'  => 150,
                'is_active'      => true,
            ]
        );

        $locCimanggis = SqrLocation::firstOrCreate(
            ['code' => 'SQR-CIMANGGIS'],
            [
                'name'           => 'SQR Cabang Cimanggis',
                'address'        => 'Jl. Raya Bogor KM 30, Cimanggis Depok',
                'latitude'       => '-6.365',
                'longitude'      => '106.865',
                'radius_meters'  => 150,
                'is_active'      => true,
            ]
        );

        // 3. Seed Classes
        $kelasAnak = SqrClass::firstOrCreate(
            ['class_name' => 'Kelas Anak (Ummi 1 - 6)'],
            [
                'description'           => 'Kelas anak 5-12 thn',
                'quota'                 => 30,
                'location_id'           => $locUtama->id,
                'start_time'            => '15:30',
                'end_time'              => '17:00',
                'attendance_start_time' => '15:30',
                'attendance_end_time'   => '16:15',
                'certificate_target'    => 100,
                'recommendation_target' => 50,
            ]
        );

        $kelasRemaja = SqrClass::firstOrCreate(
            ['class_name' => 'Kelas Remaja (Tahfidz Juz 30)'],
            [
                'description'           => 'Kelas remaja 13-17 thn',
                'quota'                 => 30,
                'location_id'           => $locUtama->id,
                'start_time'            => '15:30',
                'end_time'              => '17:00',
                'attendance_start_time' => '15:30',
                'attendance_end_time'   => '16:15',
                'certificate_target'    => 100,
                'recommendation_target' => 50,
            ]
        );

        $kelasDewasa = SqrClass::firstOrCreate(
            ['class_name' => 'Kelas Dewasa (Tahsin Al-Quran)'],
            [
                'description'           => 'Kelas dewasa 18+ thn',
                'quota'                 => 30,
                'location_id'           => $locUtama->id,
                'start_time'            => '15:30',
                'end_time'              => '17:00',
                'attendance_start_time' => '15:30',
                'attendance_end_time'   => '16:15',
                'certificate_target'    => 100,
                'recommendation_target' => 50,
            ]
        );

        // 4. Seed Main Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@sqr.id'],
            [
                'name'        => 'Admin Utama SQR',
                'password'    => bcrypt('password'),
                'is_active'   => true,
                'location_id' => $locUtama->id,
            ]
        );
        $admin->assignRole('admin');

        $ustadz = User::firstOrCreate(
            ['email' => 'ustadz@sqr.id'],
            [
                'name'        => 'Ust. Ahmad Fauzi',
                'password'    => bcrypt('password'),
                'is_active'   => true,
                'class_id'    => $kelasAnak->id,
                'gender'      => 'L',
                'location_id' => $locUtama->id,
            ]
        );
        $ustadz->assignRole('ustadz');

        $ustadzah = User::firstOrCreate(
            ['email' => 'ustadzah.fatimah@sqr.id'],
            [
                'name'        => 'Ustadzah Fatimah Az-Zahra, S.Pd.I',
                'password'    => bcrypt('password'),
                'is_active'   => true,
                'gender'      => 'Perempuan',
                'phone'       => '081299887766',
                'location_id' => $locUtama->id,
            ]
        );
        $ustadzah->assignRole('ustadz');

        $wali = User::firstOrCreate(
            ['email' => 'wali@sqr.id'],
            [
                'name'        => 'Bpk. Hendra Pratama',
                'password'    => bcrypt('password'),
                'is_active'   => true,
                'gender'      => 'L',
                'location_id' => $locUtama->id,
            ]
        );
        $wali->assignRole('wali');

        // 5. Seed Santri
        $santri1 = Santri::firstOrCreate(
            ['full_name' => 'Muhammad Rizki Pratama'],
            [
                'class_id'             => $kelasAnak->id,
                'wali_user_id'        => $wali->id,
                'is_active'            => true,
                'gender'               => 'Laki-laki',
                'parent_name'          => 'Bpk. Hendra Pratama',
                'phone'                => '081293721163',
                'enrollment_date'      => now()->subMonths(6),
                'certificate_template' => 'elegant',
            ]
        );

        $santri2 = Santri::firstOrCreate(
            ['full_name' => 'Aisyah Az-Zahra'],
            [
                'class_id'             => $kelasRemaja->id,
                'wali_user_id'        => $wali->id,
                'is_active'            => true,
                'gender'               => 'Perempuan',
                'parent_name'          => 'Bpk. Hendra Pratama',
                'phone'                => '081293721163',
                'enrollment_date'      => now()->subMonths(3),
                'certificate_template' => 'classic',
            ]
        );

        // 6. Seed Student Progress (100% mutqin Juz 30)
        StudentProgress::firstOrCreate(
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

        // 7. Seed Organization Settings
        $orgSettings = [
            'org_name'               => 'Yayasan Bina Cahaya Ilmu Rabbani (SQR)',
            'org_address'            => 'Jl. Puri Kemang Permai No.85, RT.002/008, Sukatani, Tapos Depok',
            'org_phone'              => '081293721163',
            'org_email'              => 'admin@sqr.id',
            'pembina_name'           => 'Ust. Ahmad Fauzi',
            'pembina_title'          => 'Kepala Pengasuh Saung Quran Rabbani',
            'taruna_rate_physical'   => '50000',
            'taruna_rate_online'     => '25000',
            'taruna_incentive_sub'   => '15000',
            'sqr_latitude'           => '-6.393733',
            'sqr_longitude'          => '106.878266',
            'sqr_radius_meters'      => '30',
        ];

        foreach ($orgSettings as $key => $val) {
            OrganizationSetting::firstOrCreate(['key' => $key], ['value' => $val]);
        }

        // 8. Seed Content Manager & Stats
        ContentManager::firstOrCreate(['key' => 'home_tagline'], ['value' => 'Pondasi Quran Generasi Rabbani']);
        ContentManager::firstOrCreate(['key' => 'stat_total_santri'], ['value' => '150+']);
        ContentManager::firstOrCreate(['key' => 'stat_pengajar'], ['value' => '8+']);
        ContentManager::firstOrCreate(['key' => 'stat_tahun'], ['value' => '7th']);

        // 9. Seed Articles
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

        // 10. Seed Campaigns & Galleries
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

        // 11. Run Dedicated Financial & SPP Seeders
        $this->call(SppPaymentSeeder::class);
        $this->call(FinancialSyncSeeder::class);
        $this->call(SchoolScheduleSeeder::class);

        $this->command->info('✅ DatabaseSeeder berhasil mengesekusi seluruh seeder utama!');
    }
}
