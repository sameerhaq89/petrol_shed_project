<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tank;

class TankSeeder extends Seeder
{
    public function run()
    {
        Tank::create([
            'id' => 1,
            'station_id' => 1,
            'fuel_type_id' => 1, // Petrol
            'tank_number' => 'T1',
            'tank_name' => 'Main Petrol Tank',
            'capacity' => 20000,
            'current_stock' => 15000,
            'reorder_level' => 5000,
            'minimum_level' => 1000,
            'maximum_level' => 19500,
            'status' => 'active'
        ]);
    }
}