<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Shift;
use App\Models\Tank;
use App\Models\Pump;
use App\Models\FuelType;
use App\Models\CashDrop; // <--- Added this import
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardData()
    {
        $today = \Carbon\Carbon::today();

        // 1. Top Cards Data
        $totalSalesToday = Sale::whereDate('sale_datetime', $today)->sum('final_amount');
        
        // This is the physical money collected (Cash Drops)
        $cashDropsToday = \App\Models\CashDrop::whereDate('dropped_at', $today)->sum('amount');
        
        $openShiftsCount = Shift::where('status', 'open')->count();

        // 2. Low Fuel Alerts
        $lowFuelTanks = Tank::with('fuelType')
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->get();
        $lowFuelAlertsCount = $lowFuelTanks->count();

        // 3. Sales Summary (Cash vs Card)
        // We need these TWO variables defined to fix your error:
        
        $cashSalesToday = Sale::whereDate('sale_datetime', $today)
            ->where('payment_mode', 'cash')
            ->sum('final_amount');

        // ▼▼▼ THIS IS THE MISSING LINE CAUSING YOUR ERROR ▼▼▼
        $cardSalesToday = Sale::whereDate('sale_datetime', $today)
            ->where('payment_mode', 'card')
            ->sum('final_amount');
        // ▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲

        $totalSalesForSplit = $cashSalesToday + $cardSalesToday;
        
        $cashPercent = $totalSalesForSplit > 0 ? round(($cashSalesToday / $totalSalesForSplit) * 100) : 0;
        $cardPercent = $totalSalesForSplit > 0 ? round(($cardSalesToday / $totalSalesForSplit) * 100) : 0;

        // 4. Pumps Overview
        $pumps = Pump::with(['tank.fuelType'])->get()->map(function($pump) {
            $todaysVolume = Sale::whereDate('sale_datetime', \Carbon\Carbon::today())
                ->where('pump_id', $pump->id)
                ->sum('quantity');
            $pump->todays_volume = $todaysVolume;
            return $pump;
        });

        // 5. Fuel Stock Summary
        $fuelStockSummary = FuelType::with('tanks')->get()->map(function($fuelType) {
            return [
                'name' => $fuelType->name,
                'current_stock' => $fuelType->tanks->sum('current_stock'),
                'last_dip' => $fuelType->tanks->sum('current_stock') 
            ];
        });

        // 6. Shift Summary
        $currentShift = Shift::with('user')->where('status', 'open')->latest()->first();
        $lastClosedShift = Shift::where('status', 'closed')->latest()->first();

        // 7. Tanks Data for JS
        $tanksDataForJs = [];
        $fuelTypes = FuelType::with('tanks')->get();

        foreach ($fuelTypes as $ft) {
            $key = \Illuminate\Support\Str::slug($ft->code, ''); 
            $tanksList = $ft->tanks->map(function($tank) {
                 $percent = $tank->capacity > 0 ? round(($tank->current_stock / $tank->capacity) * 100) : 0;
                 return [
                    'id' => $tank->tank_number ?? $tank->id,
                    'current' => $tank->current_stock,
                    'capacity' => $tank->capacity,
                    'percent' => $percent
                 ];
            })->take(2); 

            if($tanksList->isNotEmpty()) {
                $tanksDataForJs[$key] = ['tanks' => $tanksList];
            }
        }

        // 8. Fuel Buttons
        $fuelFilterButtons = $fuelTypes->map(function($ft) {
             return [
                 'label' => $ft->name,
                 'code' => \Illuminate\Support\Str::slug($ft->code, '')
             ];
        });

        return compact(
            'totalSalesToday',
            'cashDropsToday',
            'cashSalesToday',
            'cardSalesToday', // <--- Ensure this is included in compact()
            'openShiftsCount',
            'lowFuelAlertsCount',
            'lowFuelTanks',
            'cashPercent',
            'cardPercent',
            'totalSalesForSplit',
            'pumps',
            'fuelStockSummary',
            'currentShift',
            'lastClosedShift',
            'tanksDataForJs',
            'fuelFilterButtons'
        );
    }
}