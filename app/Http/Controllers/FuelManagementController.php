<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuelPrice;
use App\Models\FuelType;

class FuelManagementController extends Controller
{
    public function index()
    {
        // Data for Tab 1 (Prices)
        $currentPrices = FuelPrice::with('fuelType')
            ->whereNull('effective_to')
            ->orderBy('id', 'desc')
            ->get();

        $history = FuelPrice::with('fuelType')
            ->orderBy('effective_from', 'desc')
            ->get();

        // Data for Tab 2 (Fuel Types) & Dropdowns
        $fuelTypes = FuelType::all();

        return view('admin.petro.fuel-management.index', compact(
            'currentPrices',
            'history',
            'fuelTypes'
        ));
    }
}