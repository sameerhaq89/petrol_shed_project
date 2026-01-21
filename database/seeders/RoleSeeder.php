<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            // 1. You (Software Provider)
            ['id' => 1, 'name' => 'Super Admin', 'slug' => 'super-admin', 'is_system_role' => 1, 'priority' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // 2. Station Owner (The Client)
            ['id' => 2, 'name' => 'Station Admin', 'slug' => 'admin', 'is_system_role' => 1, 'priority' => 2, 'created_at' => now(), 'updated_at' => now()],
            
            // 3. Employees
            ['id' => 3, 'name' => 'Manager', 'slug' => 'manager', 'is_system_role' => 1, 'priority' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Pumper', 'slug' => 'pumper', 'is_system_role' => 1, 'priority' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}