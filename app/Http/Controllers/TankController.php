<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTankRequest;
use App\Http\Requests\UpdateTankRequest;
use App\Http\Requests\AdjustTankStockRequest;
use App\Services\TankService;
use App\Services\PumpService; // Added PumpService
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TankController extends Controller
{
    protected $tankService;
    protected $pumpService;

    // Inject both TankService and PumpService
    public function __construct(TankService $tankService, PumpService $pumpService)
    {
        $this->tankService = $tankService;
        $this->pumpService = $pumpService;
    }

    /**
     * Display the Dashboard with Tanks and Pumps.
     */
    public function index(Request $request): View
    {
        // 1. Get raw tanks from DB
        $rawTanks = $this->tankService->getAllTanks($request->all());

        // 2. Transform Tank Models into Widget Arrays for Blade
        $tanks = $rawTanks->map(function ($tank) {
            $percentage = $tank->capacity > 0 
                ? ($tank->current_stock / $tank->capacity) * 100 
                : 0;

            return [
                'id'          => $tank->id,
                // FIX: Use 'tank_name' based on your DB schema
                'tankName'    => $tank->tank_name, 
                'capacity'    => number_format($tank->capacity) . ' L',
                'current'     => number_format($tank->current_stock) . ' L',
                'percentage'  => round($percentage, 0),
                'color'       => $this->getFuelColor($tank->fuel_type_id), // Adjusted to check ID or join table
                'lastDip'     => $tank->updated_at->diffForHumans(),
                'alertStatus' => $percentage < 15 ? 'low-stock' : 'normal',
            ];
        });

        // 3. Get Real Pumps from PumpService
        $pumps = $this->pumpService->getPumpsForDashboard();

        // 4. Page Header Configuration
        $pageHeader = [
            'title' => 'Tank & Pump Management',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => url('/')],
                ['name' => 'Tanks', 'url' => '#']
            ]
        ];

        return view('admin.petro.tank-management.index', [
            'tanks'      => $tanks,
            'pumps'      => $pumps,
            'pageHeader' => $pageHeader
        ]);
    }

    /**
     * Show form to create a new tank.
     */
    public function create(): View
    {
        return view('admin.petro.tank-management.create');
    }

    /**
     * Store a new tank.
     */
    public function store(StoreTankRequest $request): RedirectResponse
    {
        try {
            $this->tankService->createTank($request->validated());
            return redirect()->route('tanks.index')->with('success', 'Tank created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating tank: ' . $e->getMessage());
        }
    }

    /**
     * Show a specific tank.
     */
    public function show($id): View
    {
        $tank = $this->tankService->getTankById($id);
        return view('admin.petro.tank-management.show', compact('tank'));
    }

    /**
     * Show form to edit a tank.
     */
    public function edit($id): View
    {
        $tank = $this->tankService->getTankById($id);
        return view('admin.petro.tank-management.edit', compact('tank'));
    }

    /**
     * Update tank details.
     */
    public function update(UpdateTankRequest $request, $id): RedirectResponse
    {
        try {
            $this->tankService->updateTank($id, $request->validated());
            return redirect()->route('tanks.index')->with('success', 'Tank updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating tank.');
        }
    }

    /**
     * Delete a tank.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->tankService->deleteTank($id);
            return redirect()->route('tanks.index')->with('success', 'Tank deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting tank.');
        }
    }

    /**
     * Handle stock adjustments (Dip Readings/Refills).
     */
    public function adjustStock(AdjustTankStockRequest $request, $id): RedirectResponse
    {
        try {
            $this->tankService->adjustStock(
                $id,
                $request->quantity,
                $request->type,
                $request->reason
            );

            return back()->with('success', 'Stock adjusted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Helper to determine color based on fuel type ID or Name.
     * You may need to adjust the logic depending on if you pass an ID or a string.
     */
    private function getFuelColor($type)
    {
        // Example: If $type is an ID, you might map IDs to colors
        // Or if you join the table, check the name.
        // Simple fallback logic:
        return match ($type) {
            1, 'Petrol', 'Gasoline' => 'orange',
            2, 'Diesel'             => 'blue',
            3, 'Kerosene'           => 'purple',
            default                 => 'green', // Default for unknown
        };
    }
}