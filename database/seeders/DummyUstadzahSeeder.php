<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UstadzAttendance;
use Spatie\Permission\Models\Role;

class DummyUstadzahSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'ustadz']);

        $ustadzah = User::updateOrCreate(
            ['email' => 'ustadzah.fatimah@sqr.id'],
            [
                'name'      => 'Ustadzah Fatimah Az-Zahra, S.Pd.I',
                'password'  => bcrypt('password'),
                'gender'    => 'Perempuan',
                'phone'     => '081299887766',
                'is_active' => true,
            ]
        );

        if (!$ustadzah->hasRole('ustadz')) {
            $ustadzah->assignRole('ustadz');
        }

        // Record Hadir attendance for today (2026-08-20)
        UstadzAttendance::updateOrCreate(
            [
                'ustadz_id' => $ustadzah->id,
                'date'      => '2026-08-20',
            ],
            [
                'status'        => 'Hadir',
                'check_in_time' => '08:00:00',
                'notes'         => 'Presensi HADIR Ustadzah Pengganti Aktif Hari Ini',
            ]
        );
    }
}
