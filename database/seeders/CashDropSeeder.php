<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CashDrop;
use Carbon\Carbon;

class CashDropSeeder extends Seeder
{
    public function run()
    {
        CashDrop::create([
            'shift_id' => 1,
            'user_id' => 4, // Pumper Anil
            'amount' => 5000.00,
            'dropped_at' => Carbon::now()->subMinutes(30),
            'status' => 'pending',
            'notes' => 'Mid-shift drop'
        ]);
    }
}