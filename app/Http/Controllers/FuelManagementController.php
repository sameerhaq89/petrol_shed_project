<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuelPrice;
use App\Models\FuelType;

class FuelManagementController extends Controller
{
    protected $fuelPriceService;
    protected $fuelPriceRepository; // Or just use the service if it exposes history

    public function __construct(\App\Services\FuelPriceService $fuelPriceService)
    {
        $this->fuelPriceService = $fuelPriceService;
    }

    public function index()
    {
        $pageHeader = [
            'title' => 'Fuel Management',
            'icon' => 'mdi mdi-fuel',
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'url'   => route('home'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Fuel Management',
                    'url'   => null, // active item
                ],
            ],
        ];

        // Retrieve data via Service (which uses Repository with Station ID filter)
        $data = $this->fuelPriceService->getDashboardData();

        $currentPrices = $data['current'];
        $history = $data['history'];

        // Data for Tab 2 (Fuel Types) & Dropdowns
        // Fuel Types are generally global, but if we wanted to show only active ones:
        $fuelTypes = FuelType::all(); // or where('is_active', true)->get();

        return view('admin.petro.fuel-management.index', compact(
            'currentPrices',
            'history',
            'fuelTypes',
            'pageHeader'
        ));
    }
}
