<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Tank;
use App\Models\Pump;
use App\Models\StockMovement;
use App\Models\Shift;
use App\Models\PumpOperatorAssignment;

class SaleSeeder extends Seeder
{
    public function run()
    {
        $shift = Shift::find(1);
        $assignment = PumpOperatorAssignment::find(1);
        $pump = Pump::find(1);
        $tank = Tank::find(1);
        
        // Price for Petrol
        $price = 370.00;

        // Simulate 3 Sales
        $this->createSale($shift, $assignment, 10, $price, $tank, $pump);
        $this->createSale($shift, $assignment, 25, $price, $tank, $pump);
        $this->createSale($shift, $assignment, 5, $price, $tank, $pump);
        
        // Update Shift Totals after sales
        $totalVol = 40; // 10 + 25 + 5
        $totalAmt = 40 * $price;

        $shift->update([
            'total_sales' => $totalAmt,
            'total_fuel_sold' => $totalVol
        ]);
    }

    private function createSale($shift, $assignment, $qty, $price, $tank, $pump)
    {
        $amount = $qty * $price;
        $startMeter = $pump->current_reading;
        $endMeter = $startMeter + $qty;

        Sale::create([
            'sale_number' => 'SL-' . rand(10000, 99999),
            'shift_id' => $shift->id,
            'station_id' => $shift->station_id,
            'pump_id' => $pump->id,
            'fuel_type_id' => $tank->fuel_type_id,
            'created_by' => $assignment->user_id,
            'quantity' => $qty,
            'rate' => $price,
            'amount' => $amount,
            'final_amount' => $amount,
            'start_reading' => $startMeter,
            'end_reading' => $endMeter,
            'status' => 'completed',
            'sale_datetime' => now(),
            'payment_mode' => 'cash'
        ]);

        // Update Infrastructure
        $tank->decrement('current_stock', $qty);
        $pump->update(['current_reading' => $endMeter]);

        // Record Movement
        StockMovement::create([
            'tank_id' => $tank->id,
            'type' => 'sales',
            'quantity' => $qty,
            'balance_after' => $tank->current_stock,
            'reference_type' => 'shift',
            'reference_id' => $shift->id,
            'recorded_at' => now()
        ]);
    }
}