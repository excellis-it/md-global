<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionRoleSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::firstOrCreate(['name' => 'ADMIN']);

        $permissions = Permission::pluck('name')->toArray();

        // Assign all permissions to admin
        $admin->syncPermissions($permissions);
    }
}
