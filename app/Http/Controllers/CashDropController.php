<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CashDropService;
use App\Http\Requests\StoreCashDropRequest; 
use Illuminate\Http\Request;

class CashDropController extends Controller
{
    protected $cashDropService;

    public function __construct(CashDropService $cashDropService)
    {
        $this->cashDropService = $cashDropService;
    }

    public function store(StoreCashDropRequest $request)
    {
        try {
            // The Service handles finding the shift and saving
            $drop = $this->cashDropService->createDrop($request->validated());

            return back()->with('success', 'Cash drop recorded successfully: Rs. ' . number_format($drop->amount, 2));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function verify($id)
    {
        try {
            $this->cashDropService->verifyDrop($id);
            return back()->with('success', 'Cash drop verified.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error verifying drop.');
        }
    }

    public function destroy($id)
    {
        $this->cashDropService->deleteDrop($id);
        return back()->with('success', 'Cash drop deleted.');
    }
}