<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-users',
            'manage-santri',
            'manage-classes',
            'verify-payments',
            'input-progress',
            'view-own-santri',
            'manage-ppdb',
            'manage-attendance',
            'manage-finance',
            'manage-content',
            'manage-articles',
            'send-notifications',
            'view-audit-log',
            'input-self-attendance',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin — semua permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // Ustadz
        $ustadz = Role::firstOrCreate(['name' => 'ustadz']);
        $ustadz->givePermissionTo([
            'input-progress',
            'manage-attendance',
            'input-self-attendance',
            'view-own-santri',
        ]);

        // Wali Santri
        $wali = Role::firstOrCreate(['name' => 'wali']);
        $wali->givePermissionTo([
            'view-own-santri',
        ]);

        $this->command->info('✅ Roles & Permissions selesai dibuat.');
    }
}
