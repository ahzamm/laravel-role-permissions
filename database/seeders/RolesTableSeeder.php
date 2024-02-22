<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    { {
            Role::create(['id' => 1, 'name' => 'admin', 'guard_name' => 'sanctum']);
        }
    }
}
