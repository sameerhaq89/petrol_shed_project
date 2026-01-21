<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFuelPriceRequest; // Import the Request
use App\Services\FuelPriceService;
use App\Models\FuelType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FuelPriceController extends Controller
{
    protected $fuelPriceService;

    public function __construct(FuelPriceService $fuelPriceService)
    {
        $this->fuelPriceService = $fuelPriceService;
    }

    public function index(): View
    {
        $data = $this->fuelPriceService->getDashboardData();
        $fuelTypes = FuelType::where('is_active', true)->get();

        $pageHeader = [
            'title' => 'Fuel Price Management',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('home')],
                ['name' => 'Fuel Prices', 'url' => '#']
            ]
        ];

        return view('admin.petro.fuel-price.index', [
            'currentPrices' => $data['current'],
            'history'       => $data['history'],
            'fuelTypes'     => $fuelTypes,
            'pageHeader'    => $pageHeader
        ]);
    }


    public function store(StoreFuelPriceRequest $request): RedirectResponse
    {
        try {
            $this->fuelPriceService->createPrice($request->validated());
            return back()->with('success', 'Fuel price updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating price: ' . $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->fuelPriceService->deletePrice($id);
            return back()->with('success', 'Price record deleted.');
        } catch (\Exception $e) {
             return back()->with('error', 'Error deleting price.');
        }
    }
}