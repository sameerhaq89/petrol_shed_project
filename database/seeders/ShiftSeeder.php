<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use App\Models\PumpOperatorAssignment;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Shift
        $shift = Shift::create([
            'id' => 1,
            'shift_number' => 'SH-' . date('Ymd') . '-01',
            'station_id' => 1,
            'user_id' => 2, // Manager John
            'shift_date' => now()->toDateString(),
            'start_time' => Carbon::now()->subHours(4), 
            'status' => 'open',
            'opening_cash' => 5000.00, // Office Safe
            'total_sales' => 0.00
        ]);

        // 2. Create Assignment (Pumper Anil)
        PumpOperatorAssignment::create([
            'id' => 1,
            'shift_id' => $shift->id,
            'user_id' => 3, // Pumper Anil
            'pump_id' => 1, // Pump 1
            'start_time' => Carbon::now()->subHours(4),
            'opening_reading' => 100000.00,
            'opening_cash' => 5000.00, // Float given to Anil
            'status' => 'active' 
        ]);
    }
}