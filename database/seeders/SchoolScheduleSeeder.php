<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolSchedule;
use App\Models\SchoolEvent;
use App\Models\User;

class SchoolScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Default TPQ SQR schedule settings:
        // Jam Belajar: 16:00 s/d 17:30 WIB
        // Hari Libur Mingguan: 6,0 (Sabtu & Minggu)
        $defaults = [
            'jam_masuk'          => '16:00',
            'jam_pulang'         => '17:30',
            'libur_mingguan'     => '6,0', // 6 = Sabtu, 0 = Minggu (Ahad)
            'nama_sekolah'       => 'Saung Quran Rabbani',
            'kelas_mulai_tanggal'=> '2026-01-01',
        ];

        foreach ($defaults as $key => $value) {
            SchoolSchedule::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $admin = User::role('admin')->first();
        $currMonth = now()->format('Y-m');

        // Sample events
        $sampleEvents = [
            [
                'date'        => $currMonth . '-17',
                'title'       => 'Libur Kemerdekaan RI ke-81',
                'description' => 'Memperingati Hari Kemerdekaan Republik Indonesia, kegiatan belajar mengajar diliburkan.',
                'type'        => 'libur',
                'is_holiday'  => true,
                'created_by'  => $admin?->id,
            ],
            [
                'date'        => now()->addDays(3)->format('Y-m-d'),
                'title'       => 'Kajian Parenting & Quran Bulan Ini',
                'description' => 'Kajian bulanan khusus Wali Santri bersama Pembina Yayasan. Harap hadir pukul 16:00 WIB.',
                'type'        => 'acara',
                'is_holiday'  => false,
                'created_by'  => $admin?->id,
            ],
            [
                'date'        => now()->addDays(7)->format('Y-m-d'),
                'title'       => 'Kelas Online Pengganti (Zoom)',
                'description' => 'Kelas online via Zoom menggantikan pertemuan tatap muka.',
                'type'        => 'online',
                'is_holiday'  => false,
                'online_link' => 'https://meet.google.com/sqr-online-001',
                'online_start_time' => '16:00:00',
                'created_by'  => $admin?->id,
            ],
            [
                'date'        => now()->addDays(12)->format('Y-m-d'),
                'date_end'    => now()->addDays(14)->format('Y-m-d'),
                'title'       => 'Pesantren Kilat & Mabit Santri',
                'description' => 'Kegiatan Sanlat dan Malam Bina Iman Taqwa (MABIT) untuk seluruh santri SQR.',
                'type'        => 'acara',
                'is_holiday'  => false,
                'created_by'  => $admin?->id,
            ],
        ];

        foreach ($sampleEvents as $event) {
            SchoolEvent::updateOrCreate(
                ['date' => $event['date'], 'title' => $event['title']],
                $event
            );
        }

        $this->command->info('✅ School schedule settings (16:00-17:30, Sabtu-Minggu libur) seeded successfully.');
    }
}
