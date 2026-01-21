<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuelType;

class FuelTypeSeeder extends Seeder
{
    public function run()
    {
        FuelType::create([
            'id' => 1,
            'name' => 'Petrol 92', 'code' => 'P92', 
            'unit' => 'L', 'density' => 0.74, 'color_code' => '#ff0000', 
            'is_active' => 1
        ]);

        FuelType::create([
            'id' => 2,
            'name' => 'Auto Diesel', 'code' => 'D-AUTO', 
            'unit' => 'L', 'density' => 0.83, 'color_code' => '#000000', 
            'is_active' => 1
        ]);
    }
}