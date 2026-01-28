<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFuelTypeRequest;
use App\Http\Requests\UpdateFuelTypeRequest;
use App\Services\FuelTypeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FuelTypeController extends Controller
{
    protected $fuelTypeService;

    public function __construct(FuelTypeService $fuelTypeService)
    {
        $this->fuelTypeService = $fuelTypeService;
    }

    public function index(): View
    {
        $fuelTypes = $this->fuelTypeService->getAllFuelTypes();

        $pageHeader = [
            'title' => 'Fuel Types',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('home')],
                ['name' => 'Settings', 'url' => null],
                ['name' => 'Fuel Types', 'url' => null],
            ],
        ];

        return view('admin.petro.fuel-type.index', compact('fuelTypes', 'pageHeader'));
    }

    public function store(StoreFuelTypeRequest $request): RedirectResponse
    {
        try {
            $this->fuelTypeService->createFuelType($request->validated());

            return back()->with('success', 'New fuel type added successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating fuel type: '.$e->getMessage());
        }
    }

    public function update(UpdateFuelTypeRequest $request, $id): RedirectResponse
    {
        try {
            $this->fuelTypeService->updateFuelType($id, $request->validated());

            return back()->with('success', 'Fuel type updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating fuel type: '.$e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->fuelTypeService->deleteFuelType($id);

            return back()->with('success', 'Fuel type deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting fuel type.');
        }
    }
}
