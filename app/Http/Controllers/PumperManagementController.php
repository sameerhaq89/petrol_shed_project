<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignPumperRequest;
use App\Http\Requests\CloseDutyRequest;
use App\Http\Requests\SettleShortageRequest;
use App\Models\PumpOperatorAssignment;
use App\Services\PumperService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PumperManagementController extends Controller
{
    protected $pumperService;

    public function __construct(PumperService $pumperService)
    {
        $this->pumperService = $pumperService;
    }

    public function index()
    {
        $data = $this->pumperService->getDashboardData();

        $pageHeader = [
            'title' => 'Pumper Management',
            'icon' => 'mdi mdi-account-hard-hat',
        ];

        return view('admin.petro.pumper-management.index', array_merge($data, ['pageHeader' => $pageHeader]));

    }

    public function dashboard()
    {
        $user = auth()->user();
        $assignment = PumpOperatorAssignment::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->with(['pump'])
            ->first();

        if (!$assignment) {
            return view('pumpers.no-assignment');
        }

        // Calculate Data
        $totalSales = \App\Models\Sale::where('shift_id', $assignment->shift_id)
            ->where('created_by', $user->id)
            ->sum('amount');

        $totalCashSales = \App\Models\Sale::where('shift_id', $assignment->shift_id)
            ->where('created_by', $user->id)
            ->where('payment_mode', 'cash')
            ->sum('amount');

        $totalDropped = \App\Models\CashDrop::where('shift_id', $assignment->shift_id)
            ->where('user_id', $user->id)
            ->sum('amount');

        $openingFloat = $assignment->opening_cash ?? 0;
        $cashInHand = $openingFloat + $totalCashSales - $totalDropped;

        $recentDrops = \App\Models\CashDrop::where('shift_id', $assignment->shift_id)
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pumpers.dashboard', compact('assignment', 'totalSales', 'totalDropped', 'cashInHand', 'recentDrops'));
    }

    public function assignPumper(AssignPumperRequest $request): RedirectResponse
    {
        try {
            $this->pumperService->assignPumper($request->validated());

            return back()->with('success', 'Pumper Assigned. Float Given: Rs. ' . number_format($request->opening_cash, 2));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function closeDutyForm($id)
    {
        $data = $this->pumperService->getCloseDutyData($id);
        $assignment = $data['assignment'];

        if ($assignment->status == 'completed') {
            return redirect()->route('pumper.index')->with('error', 'This duty is already closed.');
        }

        $pageHeader = [
            'title' => 'Close Duty: ' . $assignment->pumper->name,
            'breadcrumbs' => [
                ['name' => 'Pumpers', 'url' => route('pumper.index')],
                ['name' => 'Close Duty', 'url' => '#'],
            ],
        ];

        return view('admin.petro.pumper-management.close-duty', array_merge($data, ['pageHeader' => $pageHeader]));
    }

    public function processCloseDuty(CloseDutyRequest $request, $id): RedirectResponse
    {
        try {
            $status = $this->pumperService->closeDuty(
                $id,
                $request->closing_reading,
                $request->closing_cash_received
            );

            return redirect()->route('pumper.index')->with('success', 'Duty closed. Status: ' . $status);
        } catch (\Exception $e) {
            return back()->with('error', 'Error closing duty: ' . $e->getMessage());
        }
    }

    public function showLedger($pumperId)
    {
        $data = $this->pumperService->getLedgerData($pumperId);

        return view('admin.petro.pumper-management.ledger', $data);
    }

    public function settleShortage(SettleShortageRequest $request, $id): RedirectResponse
    {
        try {
            $amount = $this->pumperService->settleShortage($id, $request->settle_amount);

            return back()->with('success', 'Ledger updated. Received Rs. ' . number_format($amount, 2));
        } catch (\Exception $e) {
            return back()->with('error', 'Error settling shortage: ' . $e->getMessage());
        }
    }

    public function settlementReport($id)
    {
        $data = $this->pumperService->getCloseDutyData($id);
        $assignment = $data['assignment'];

        // Add page header
        $pageHeader = [
            'title' => 'Settlement Report: ' . $assignment->pumper->name,
            'breadcrumbs' => [
                ['name' => 'Pumpers', 'url' => route('pumper.index')],
                ['name' => 'Report', 'url' => '#'],
            ],
            'action_button' => [
                'label' => 'Print Report',
                'icon' => 'printer',
                'onclick' => 'window.print()',
            ],
        ];

        return view('admin.petro.pumper-management.report', array_merge($data, ['pageHeader' => $pageHeader]));
    }

    /**
     * Show the Sales Entry Form.
     */
    public function salesEntry()
    {
        // 1. Get the current logged-in user's active assignment
        $user = auth()->user();
        $assignment = PumpOperatorAssignment::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->with(['pump', 'pump.tank.fuelType.currentPrice'])
            ->first();

        if (!$assignment) {
            return view('pumpers.no-assignment');
        }

        $pump = $assignment->pump;

        // Ensure relationships exist to get price
        // Assuming Pump -> Tank -> FuelType -> latest Price
        // But for safety, we might need to get the price directly via FuelType
        $fuelType = \App\Models\FuelType::find($pump->fuel_type_id);

        if (!$fuelType) {
            // Fallback if pump uses tank correlation
            $tank = \App\Models\Tank::find($pump->tank_id);
            $fuelType = $tank ? $tank->fuelType : null;
        }

        if (!$fuelType) {
            return back()->with('error', 'Configuration Error: Pump not linked to fuel type.');
        }

        // Get current price
        $currentPrice = \App\Models\FuelPrice::where('fuel_type_id', $fuelType->id)
            ->whereNull('effective_to')
            ->latest('effective_from')
            ->first();

        if (!$currentPrice) {
            return back()->with('error', 'No active fuel price set for ' . $fuelType->name);
        }

        $pageHeader = [
            'title' => 'New Sale',
            'icon' => 'mdi mdi-sale',
        ];

        return view('pumpers.sales-entry', compact('assignment', 'pump', 'fuelType', 'currentPrice', 'pageHeader'));
    }

    /**
     * Store a new Sale.
     */
    public function storeSale(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'pump_id' => 'required|exists:pumps,id',
            'price_id' => 'required|exists:fuel_prices,id',
        ]);

        try {
            DB::beginTransaction();

            $pump = \App\Models\Pump::findOrFail($request->pump_id);
            $price = \App\Models\FuelPrice::findOrFail($request->price_id);
            $assignment = PumpOperatorAssignment::where('user_id', auth()->id())
                ->where('pump_id', $pump->id)
                ->where('status', 'active')
                ->firstOrFail();

            // Calculate Volume (Quantity)
            // Quantity = Amount / Rate
            $rate = $price->selling_price;
            $amount = $request->amount;
            $quantity = round($amount / $rate, 2);

            // --- 1. Handle Pump Meter Reading ---
            // Lock the pump row to prevent concurrent updates? For now, simple fetch.
            $startReading = $pump->current_reading;
            $endReading = $startReading + $quantity;

            $pump->update([
                'current_reading' => $endReading,
            ]);

            // --- 2. Handle Tank Stock ---
            // Only if tank is linked
            if ($pump->tank_id) {
                $tank = \App\Models\Tank::find($pump->tank_id);
                if ($tank) {
                    $tank->decrement('current_stock', $quantity);
                }
            }

            // Generate Sale Number
            $saleNumber = 'SALE-' . time() . '-' . rand(100, 999);

            // Create Sale Record
            $sale = \App\Models\Sale::create([
                'station_id' => $pump->station_id,
                'shift_id' => $assignment->shift_id, // Ensure assignment structure matches shift linking
                'pump_id' => $pump->id,
                'fuel_type_id' => $price->fuel_type_id,
                'sale_number' => $saleNumber,
                'sale_datetime' => now(),
                'start_reading' => $startReading,
                'end_reading' => $endReading,
                'quantity' => $quantity,
                'rate' => $rate,
                'amount' => $amount,
                'final_amount' => $amount,
                'payment_mode' => $request->payment_method ?? 'cash',
                'status' => 'completed',
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('pumper.sales.entry')->with('success', 'Sale Recorded: ' . $quantity . ' Liters for Rs. ' . $amount);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error recording sale: ' . $e->getMessage())->withInput();
        }
    }
}
