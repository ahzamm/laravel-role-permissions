<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['id' => 1, 'name' => 'role-list', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 2, 'name' => 'role-create', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 3, 'name' => 'role-edit', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 4, 'name' => 'role-delete', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 5, 'name' => 'product-list', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 6, 'name' => 'product-create', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 7, 'name' => 'product-edit', 'guard_name' => 'sanctum']);
        Permission::create(['id' => 8, 'name' => 'product-delete', 'guard_name' => 'sanctum']);
    }
}
