<?php

namespace Database\Seeders;

use App\Models\Santri;
use App\Models\StudentProgress;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentProgressSeeder extends Seeder
{
    public function run(): void
    {
        $ustadz  = User::role('ustadz')->first();
        $santriList = Santri::all();

        $progressData = [
            // Santri pertama: sudah 30 juz (100%) → sertifikat unlocked
            0 => [
                ['juz_start' => 1,  'juz_end' => 10, 'surah_memorized' => 'Juz 1-10', 'type' => 'Tahfiz'],
                ['juz_start' => 11, 'juz_end' => 20, 'surah_memorized' => 'Juz 11-20','type' => 'Tahfiz'],
                ['juz_start' => 21, 'juz_end' => 30, 'surah_memorized' => 'Juz 21-30','type' => 'Tahfiz'],
            ],
            // Santri kedua: 15 juz (50%) → rekomendasi unlocked, sertifikat locked
            1 => [
                ['juz_start' => 1, 'juz_end' => 15, 'surah_memorized' => 'Juz 1-15', 'type' => 'Tahfiz'],
            ],
            // Santri ketiga: 5 juz (16%)
            2 => [
                ['juz_start' => 1, 'juz_end' => 5, 'surah_memorized' => 'Juz 1-5', 'type' => 'Tahfiz'],
                ['juz_start' => 1, 'juz_end' => 5, 'surah_memorized' => 'Al-Fatihah, An-Nas', 'type' => 'Tahsin'],
            ],
        ];

        foreach ($progressData as $idx => $records) {
            $santri = $santriList[$idx] ?? null;
            if (!$santri) continue;

            foreach ($records as $i => $record) {
                StudentProgress::firstOrCreate(
                    [
                        'santri_id' => $santri->id,
                        'type'      => $record['type'],
                        'juz_end'   => $record['juz_end'],
                    ],
                    [
                        'date'            => now()->subDays($i * 7),
                        'juz_start'       => $record['juz_start'],
                        'surah_memorized' => $record['surah_memorized'],
                        'notes'           => 'Lancar, bacaan baik.',
                        'ustadz_user_id'  => $ustadz?->id,
                    ]
                );
            }
        }

        $this->command->info('✅ Progress hafalan dummy selesai dibuat.');
        $this->command->info('   → Santri 1: 30 juz (sertifikat UNLOCK)');
        $this->command->info('   → Santri 2: 15 juz (rekomendasi UNLOCK)');
        $this->command->info('   → Santri 3: 5 juz (keduanya LOCKED)');
    }
}
