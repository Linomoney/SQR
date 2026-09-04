<?php

namespace Database\Seeders;

use App\Models\Santri;
use App\Models\SqrClass;
use App\Models\User;
use App\Models\StudentProgress;
use Illuminate\Database\Seeder;

class SantriSeeder extends Seeder
{
    public function run(): void
    {
        $classes = SqrClass::all();
        $wali    = User::role('wali')->first();

        $santriData = [
            ['full_name' => 'Muhammad Rizki Pratama',  'gender' => 'Laki-laki',  'class_idx' => 0],
            ['full_name' => 'Siti Fatimah Az-Zahra',   'gender' => 'Perempuan',  'class_idx' => 0],
            ['full_name' => 'Abdullah Hakim',           'gender' => 'Laki-laki',  'class_idx' => 1],
            ['full_name' => 'Aisyah Nur Fadilah',      'gender' => 'Perempuan',  'class_idx' => 1],
            ['full_name' => 'Yusuf Al-Amin',            'gender' => 'Laki-laki',  'class_idx' => 2],
            ['full_name' => 'Khadijah Amelia',          'gender' => 'Perempuan',  'class_idx' => 2],
            ['full_name' => 'Umar Farouq',              'gender' => 'Laki-laki',  'class_idx' => 3],
            ['full_name' => 'Maryam Salwa',             'gender' => 'Perempuan',  'class_idx' => 3],
            ['full_name' => 'Ibrahim Khalil',           'gender' => 'Laki-laki',  'class_idx' => 4],
            ['full_name' => 'Zainab Hasanah',           'gender' => 'Perempuan',  'class_idx' => 4],
        ];

        foreach ($santriData as $data) {
            $class = $classes[$data['class_idx']] ?? $classes->first();
            Santri::firstOrCreate(
                ['full_name' => $data['full_name']],
                [
                    'gender'          => $data['gender'],
                    'parent_name'     => $wali?->name ?? 'Orang Tua',
                    'phone'           => '0812' . rand(10000000, 99999999),
                    'wali_user_id'    => $wali?->id,
                    'class_id'        => $class?->id,
                    'enrollment_date' => now()->subMonths(rand(1, 12)),
                    'is_active'       => true,
                ]
            );
        }

        $this->command->info('✅ 10 santri dummy berhasil dibuat.');
    }
}
