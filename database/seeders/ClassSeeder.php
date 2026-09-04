<?php

namespace Database\Seeders;

use App\Models\SqrClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            ['class_name' => 'Kelas Anak A',    'description' => 'Usia 7-10 tahun, Tahsin dasar', 'quota' => 20],
            ['class_name' => 'Kelas Anak B',    'description' => 'Usia 10-13 tahun, Tahfiz awal', 'quota' => 20],
            ['class_name' => 'Kelas Remaja A',  'description' => 'Usia 13-16 tahun, Tahfiz lanjut', 'quota' => 25],
            ['class_name' => 'Kelas Remaja B',  'description' => 'Usia 16-18 tahun, Murojaah intensif', 'quota' => 25],
            ['class_name' => 'Kelas Dewasa',    'description' => 'Usia 18+, Tahsin & Tahfiz dewasa', 'quota' => 30],
        ];

        foreach ($classes as $class) {
            SqrClass::firstOrCreate(
                ['class_name' => $class['class_name']],
                $class
            );
        }

        $this->command->info('✅ 5 Kelas berhasil dibuat.');
    }
}
