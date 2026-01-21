<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();

        User::create([
            'id' => 1,
            'name' => 'imara (Super)',
            'email' => 'super@imara.com',
            'phone' => '0770000000',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'is_active' => 1,
            'station_id' => null,
        ]);

        User::create([
            'id' => 2,
            'name' => 'Station Owner (Mr. Perera)',
            'email' => 'owner@purple.com',
            'phone' => '0771111111',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'is_active' => 1,
            'station_id' => 1,
        ]);

        User::create([
            'id' => 3,
            'name' => 'Manager John',
            'email' => 'manager@purple.com',
            'phone' => '0772222222',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'is_active' => 1,
            'station_id' => 1,
        ]);

        User::create([
            'id' => 4,
            'name' => 'Pumper Anil',
            'email' => 'anil@purple.com',
            'phone' => '0773333333',
            'password' => Hash::make('password'),
            'role_id' => 4,
            'is_active' => 1,
            'station_id' => 1,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
