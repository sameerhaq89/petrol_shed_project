<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;
use App\Models\User;

class StationSeeder extends Seeder
{
    public function run()
    {
        // 1. Create First Station (Purple Fuel)
        Station::create([
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

        // 2. Create Second Station (Green Fuel - for multi-station testing)
        Station::create([
            'id' => 2,
            'name' => 'Green Fuel Station',
            'station_code' => 'ST-002',
            'license_number' => 'LIC-2026-002',
            'tax_number' => 'TAX-112233',
            'admin_user_id' => 2, // Same owner
            'address' => '456 High Level Road',
            'city' => 'Nugegoda',
            'state' => 'Western Province',
            'country' => 'Sri Lanka',
            'pincode' => '00200',
            'phone' => '0118765432',
            'email' => 'station2@green.com',
            'status' => 'active'
        ]);
    }
}
