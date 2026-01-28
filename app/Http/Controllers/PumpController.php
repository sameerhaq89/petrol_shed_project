<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePumpRequest;
use App\Http\Requests\UpdatePumpRequest;
use App\Services\PumpService;
use App\Services\TankService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PumpController extends Controller
{
    protected $pumpService;

    protected $tankService;

    public function __construct(PumpService $pumpService, TankService $tankService)
    {
        $this->pumpService = $pumpService;
        $this->tankService = $tankService;
    }

    public function index(Request $request): View
    {
        $pumps = $this->pumpService->getPumpsForManagementTable();
        $tanks = $this->tankService->getAllTanks([]);
        $testing_details = [];
        $meter_readings = [];

        $pageHeader = [
            'title' => 'Pump Management',
            'icon' => 'mdi mdi-gas-station',
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('/')],
                ['label' => 'Pumps', 'url' => null],
            ],
        ];

        return view('admin.petro.pump-management.index', compact(
            'pumps',
            'tanks',
            'testing_details',
            'meter_readings',
            'pageHeader'
        ));
    }

    public function store(StorePumpRequest $request): RedirectResponse
    {
        try {
            $this->pumpService->createPump($request->validated());

            return back()->with('success', 'Pump added successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error adding pump: '.$e->getMessage());
        }
    }

    public function update(UpdatePumpRequest $request, $id): RedirectResponse
    {
        try {
            $this->pumpService->updatePump($id, $request->validated());

            return back()->with('success', 'Pump updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating pump: '.$e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->pumpService->deletePump($id);

            return back()->with('success', 'Pump deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting pump: '.$e->getMessage());
        }
    }
}
