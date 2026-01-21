<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTankRequest;
use App\Http\Requests\UpdateTankRequest;
use App\Http\Requests\AdjustTankStockRequest;
use App\Services\TankService;
use App\Services\PumpService;
use App\Models\FuelType;
use App\Models\Tank;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TankController extends Controller
{
    protected $tankService;
    protected $pumpService;

    public function __construct(TankService $tankService, PumpService $pumpService)
    {
        $this->tankService = $tankService;
        $this->pumpService = $pumpService;
    }

    /**
     * Display the Dashboard.
     * The 'Create Tank' modal widget should be @included in this index view.
     */
    public function index(Request $request): View
    {
        $rawTanks = $this->tankService->getAllTanks($request->all());

        $tanks = $rawTanks->map(function ($tank) {
            $percentage = $tank->capacity > 0 
                ? ($tank->current_stock / $tank->capacity) * 100 
                : 0;

            return [
                'id'          => $tank->id,
                'tankName'    => $tank->tank_name, 
                'capacity'    => number_format($tank->capacity) . ' L',
                'current'     => number_format($tank->current_stock) . ' L',
                'percentage'  => round($percentage, 0), 
                'color'       => $this->getFuelColor($tank->fuel_type_id),
                'lastDip'     => $tank->updated_at->diffForHumans(),
                'alertStatus' => $percentage < 15 ? 'low-stock' : 'normal',
            ];
        });

        $pumps = $this->pumpService->getPumpsForDashboard();
        $fuel_types = FuelType::where('is_active', true)->get();

        $pageHeader = [
            'title' => 'Tank & Pump Management',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => url('/')],
                ['name' => 'Tanks', 'url' => '#']
            ],
            'action_button' => [
                'label' => 'Add New Tank',
                'icon'  => 'plus',
                'modal' => '#addTankModal', // Triggers the modal widget
                'url'   => '#' 
            ]
        ];

        return view('admin.petro.tank-management.index', [
            'tanks'      => $tanks,
            'pumps'      => $pumps,
            'pageHeader' => $pageHeader,
            'fuel_types' => $fuel_types
        ]);
    }

    // --- REMOVED public function create() ---
    // Since you are using a modal widget, you don't need a separate page for creation.

    /**
     * Store a new tank.
     * This handles the POST request from your Modal Widget.
     */
    public function store(StoreTankRequest $request): RedirectResponse
    {
        try {
            $this->tankService->createTank($request->validated());
            return redirect()->route('tanks.index')->with('success', 'Tank created successfully.');
        } catch (\Exception $e) {
            // "withInput" ensures the modal can repopulate if you are using standard validation errors
            return back()->withInput()->with('error', 'Error creating tank: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $tank = Tank::with('fuelType', 'station')->findOrFail($id);
        return view('admin.petro.tank-management.show', compact('tank'));
    }

    public function edit($id): View
    {
        $tank = $this->tankService->getTankById($id);
        return view('admin.petro.tank-management.edit', compact('tank'));
    }

    public function update(UpdateTankRequest $request, $id): RedirectResponse
    {
        try {
            $this->tankService->updateTank($id, $request->validated());
            return redirect()->route('tanks.index')->with('success', 'Tank updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating tank: ' . $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->tankService->deleteTank($id);
            return redirect()->route('tanks.index')->with('success', 'Tank deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting tank.');
        }
    }

    public function adjustStock(AdjustTankStockRequest $request, $id): RedirectResponse
    {
        try {
            $this->tankService->adjustStock(
                $id,
                $request->quantity,
                $request->type,
                $request->reason
            );
            return back()->with('success', 'Stock updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating stock: ' . $e->getMessage());
        }
    }

    private function getFuelColor($type)
    {
        return match ($type) {
            1, 'Petrol', 'Gasoline' => 'blue',
            2, 'Diesel'             => 'green',
            3, 'Super Petrol'       => 'orange',
            default                 => 'blue',
        };
    }
}