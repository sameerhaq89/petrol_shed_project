<?php

namespace App\Http\Controllers;

use App\Models\cashDrop;
use App\Http\Requests\StorecashDropRequest;
use App\Http\Requests\UpdatecashDropRequest;

class CashDropController extends Controller
{
    protected $cashDropService;

    public function __construct(CashDropService $cashDropService)
    {
        $this->cashDropService = $cashDropService;
    }

    /**
     * Display a listing of the cash drops for a specific shift.
     */
    public function index(int $shiftId): View
    {
        $drops = $this->cashDropService->getDropsByShift($shiftId);
        
        // Return a Blade view with data
        return view('cash-drops.index', compact('drops', 'shiftId'));
    }

    /**
     * Show the form for creating a new cash drop.
     */
    public function create(): View
    {
        // You might need to pass stations to the view for a dropdown
        // $stations = Station::all(); 
        return view('cash-drops.create'); 
    }

    /**
     * Store a newly created cash drop in storage.
     */
    public function store(StoreCashDropRequest $request): RedirectResponse
    {
        try {
            $this->cashDropService->createDrop($request->validated());

            return redirect()
                ->route('cash-drops.index', ['shiftId' => $request->shift_id]) // Assuming shift_id is in request or handled logic
                ->with('success', 'Cash drop recorded successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error recording drop: ' . $e->getMessage());
        }
    }

    /**
     * Verify a specific cash drop.
     */
    public function verify(int $id): RedirectResponse
    {
        try {
            $this->cashDropService->verifyDrop($id);

            return back()->with('success', 'Cash drop verified successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}