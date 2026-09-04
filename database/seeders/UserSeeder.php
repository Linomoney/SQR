<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SqrClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $class1 = SqrClass::first();

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@sqr.id'],
            [
                'name'     => 'Administrator SQR',
                'password' => Hash::make('password'),
                'is_active'=> true,
            ]
        );
        $admin->assignRole('admin');

        // Ustadz 1
        $ustadz1 = User::firstOrCreate(
            ['email' => 'ustadz@sqr.id'],
            [
                'name'     => 'Ust. Ahmad Fauzi',
                'password' => Hash::make('password'),
                'class_id' => $class1?->id,
                'is_active'=> true,
            ]
        );
        $ustadz1->assignRole('ustadz');

        // Ustadz 2
        $ustadz2 = User::firstOrCreate(
            ['email' => 'ustadzah@sqr.id'],
            [
                'name'     => 'Ustadzah Aisyah Putri',
                'password' => Hash::make('password'),
                'is_active'=> true,
            ]
        );
        $ustadz2->assignRole('ustadz');

        // Wali 1
        $wali1 = User::firstOrCreate(
            ['email' => 'wali@sqr.id'],
            [
                'name'     => 'Bapak Budi Santoso',
                'password' => Hash::make('password'),
                'is_active'=> true,
                'address'  => 'Jl. Merpati No. 5, Bogor',
            ]
        );
        $wali1->assignRole('wali');

        // Wali 2
        $wali2 = User::firstOrCreate(
            ['email' => 'wali2@sqr.id'],
            [
                'name'     => 'Ibu Siti Rahayu',
                'password' => Hash::make('password'),
                'is_active'=> true,
            ]
        );
        $wali2->assignRole('wali');

        $this->command->info('✅ User accounts selesai dibuat:');
        $this->command->table(
            ['Email', 'Role', 'Password'],
            [
                ['admin@sqr.id',    'admin',  'password'],
                ['ustadz@sqr.id',   'ustadz', 'password'],
                ['ustadzah@sqr.id', 'ustadz', 'password'],
                ['wali@sqr.id',     'wali',   'password'],
                ['wali2@sqr.id',    'wali',   'password'],
            ]
        );
    }
}
