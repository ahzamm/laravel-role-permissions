<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all();
        $adminRole = Role::where('name', 'admin')->first();
        
        foreach ($permissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }
    }
}
