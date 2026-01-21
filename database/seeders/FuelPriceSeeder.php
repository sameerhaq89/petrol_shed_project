<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuelPrice;

class FuelPriceSeeder extends Seeder
{
    public function run()
    {
        FuelPrice::create([
            'station_id' => 1,
            'fuel_type_id' => 1, // Petrol
            'purchase_price' => 350.00,
            'selling_price' => 370.00,
            'effective_from' => now()->subDays(10)
        ]);

        FuelPrice::create([
            'station_id' => 1,
            'fuel_type_id' => 2, // Diesel
            'purchase_price' => 300.00,
            'selling_price' => 330.00,
            'effective_from' => now()->subDays(10)
        ]);
    }
}