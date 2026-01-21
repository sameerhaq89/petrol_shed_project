<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;
use App\Models\User;

class StationSeeder extends Seeder
{
    public function run()
    {
        // 1. Create the Station
        // User 1 exists now, so 'admin_user_id' => 1 is safe.
        $station = Station::create([
            'id' => 1,
            'name' => 'Purple Fuel Station',
            'station_code' => 'ST-001',
            'license_number' => 'LIC-2026-001',
            'tax_number' => 'TAX-998877',
            'admin_user_id' => 2, 
            'address' => '123 Main Street',
            'city' => 'Colombo',
            'state' => 'Western Province',
            'country' => 'Sri Lanka',
            'pincode' => '00100',
            'phone' => '0112345678',
            'email' => 'station@purple.com',
            'status' => 'active'
        ]);

        // 2. NOW update the users to belong to this station
        // This is safe because both User and Station exist now.
        User::whereIn('id', [2, 3, 4])->update(['station_id' => $station->id]);
    }
}