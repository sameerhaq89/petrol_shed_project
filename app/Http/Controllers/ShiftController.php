<?php

namespace App\Http\Controllers;

use App\Http\Requests\CloseShiftRequest;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\StoreShiftSaleRequest;
use App\Models\Pump;
use App\Models\Shift;
use App\Models\User;
use App\Services\ShiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    protected $shiftService;

    public function __construct(ShiftService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    public function index(Request $request)
    {
        $settlements = $this->shiftService->getAllShifts($request->all());

        $pageHeader = [
            'title' => 'Settlement List',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('home')],
                ['name' => 'Settlements', 'url' => '#'],
            ],
            'action_button' => [
                'label' => 'Open New Shift',
                'icon' => 'plus',
                'modal' => '#openShiftModal',
            ],
        ];

        return view('admin.petro.settlement-list.index', compact('settlements', 'pageHeader'));
    }

    public function store(StoreShiftRequest $request)
    {
        try {
            $shift = $this->shiftService->openShift($request->validated());

            return redirect()->route('settlement.entry', $shift->id)->with('success', 'Shift Opened!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $shift = $this->shiftService->getShiftById($id);

        $pumps = Pump::where('station_id', $shift->station_id)
            ->where('status', 'active')
            ->get();

        // Fix: Use correct Role ID for Pumper (4), or lookup by slug
        $pumperRole = \App\Models\Role::where('slug', 'pumper')->first();
        $pumperRoleId = $pumperRole ? $pumperRole->id : 4;

        $pumpers = User::where('role_id', $pumperRoleId)->where('is_active', 1)->get();

        $pageHeader = [
            'title' => 'Shift Settlement: ' . $shift->shift_number,
            'breadcrumbs' => [
                ['name' => 'Settlement List', 'url' => route('settlement-list.index')],
                ['name' => 'Entry', 'url' => '#'],
            ],
        ];

        return view('admin.petro.settlement.index', compact('shift', 'pumps', 'pumpers', 'pageHeader'));
    }

    public function saveReading(StoreShiftSaleRequest $request)
    {
        try {
            $this->shiftService->recordReading($request->validated());

            return back()->with('success', 'Reading added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function close(CloseShiftRequest $request)
    {
        $stationId = Auth::user()->station_id ?? 1;
        $shift = Shift::where('station_id', $stationId)
            ->where('status', 'open')
            ->latest()->first();

        if (!$shift) {
            return back()->with('error', 'No active shift found to close.');
        }

        try {
            $result = $this->shiftService->closeShift(
                $shift->id,
                $request->closing_cash,
                $request->closing_notes
            );

            $msg = 'Shift settled. Variance: Rs. ' . number_format($result->shift->cash_variance, 2);
            if ($result->unsettled_count > 0) {
                $msg .= ' (Warning: ' . $result->unsettled_count . ' pumpers have unsettled shortages carried forward)';

                return redirect()->route('settlement-list.index')->with('warning', $msg);
            }

            return redirect()->route('settlement-list.index')->with('success', $msg);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteSale($id)
    {
        try {
            $this->shiftService->deleteSale($id);

            return back()->with('success', 'Entry deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting sale.');
        }
    }

    public function directEntry()
    {
        $stationId = Auth::user()->station_id ?? 1;

        $openShift = \App\Models\Shift::where('station_id', $stationId)
            ->where('status', 'open')
            ->latest()
            ->first();

        if ($openShift) {
            return redirect()->route('settlement.entry', $openShift->id);
        }

        return redirect()->route('settlement-list.index')
            ->with('warning', 'No active shift found. Please open a new shift first.');
    }
}
