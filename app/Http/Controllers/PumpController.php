<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePumpRequest;
use App\Http\Requests\UpdatePumpRequest;
use App\Services\PumpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PumpController extends Controller
{
    protected $pumpService;

    public function __construct(PumpService $pumpService)
    {
        $this->pumpService = $pumpService;
    }

    public function index(): View
    {
        // 1. Get formatted data for the "Pumps" tab table
        $pumps = $this->pumpService->getPumpsForManagementTable();

        // 2. Page Header Config
        $pageHeader = [
            'title' => 'Pump Management',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => url('/')],
                ['name' => 'Pumps', 'url' => '#']
            ],
            'action_button' => [
                'url' => '#', 
                'label' => 'Add Pump', 
                'icon' => 'plus',
                'modal' => '#addPumpModal' 
            ]
        ];

        // 3. FIX: Use strict snake_case names for ALL view variables
        $testing_details = []; 
        $meter_readings = [];  // Changed from $meterReadings to $meter_readings

        // 4. Pass them to the view
        return view('admin.petro.pump-management.index', compact(
            'pumps', 
            'pageHeader', 
            'testing_details', 
            'meter_readings'   // Must match the variable name above
        ));
    }

    public function store(StorePumpRequest $request): RedirectResponse
    {
        try {
            $this->pumpService->createPump($request->validated());
            return redirect()->back()->with('success', 'Pump added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error adding pump: ' . $e->getMessage());
        }
    }

    public function update(UpdatePumpRequest $request, $id): RedirectResponse
    {
        try {
            $this->pumpService->updatePump($id, $request->validated());
            return redirect()->back()->with('success', 'Pump updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating pump.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->pumpService->deletePump($id);
            return redirect()->back()->with('success', 'Pump deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting pump.');
        }
    }
}