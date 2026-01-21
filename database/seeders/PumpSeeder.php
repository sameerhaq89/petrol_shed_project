<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pump;

class PumpSeeder extends Seeder
{
    public function run()
    {
        Pump::create([
            'id' => 1,
            'station_id' => 1,
            'tank_id' => 1, // Linked to Petrol Tank
            'pump_number' => 'P1',
            'pump_name' => 'Island 1 - Petrol',
            'opening_reading' => 100000.00,
            'current_reading' => 100000.00,
            'status' => 'active'
        ]);
    }
}