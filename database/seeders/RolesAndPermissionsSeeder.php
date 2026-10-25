<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view-dashboard',
            'manage-customers',
            'manage-leads',
            'manage-quotes',
            'manage-jobs',
            'manage-safety-checks',
            'use-chatbot',
            'view-audit-logs',
            'manage-users',
            'manage-roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions($permissions);

        $electrician = Role::firstOrCreate(['name' => 'electrician', 'guard_name' => 'web']);
        $electrician->syncPermissions([
            'view-dashboard',
            'manage-quotes',
            'manage-jobs',
            'manage-safety-checks',
            'use-chatbot',
        ]);
    }
}
