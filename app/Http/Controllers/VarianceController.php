<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExplainVarianceRequest;
use App\Services\VarianceService;
use App\Models\Shift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VarianceController extends Controller
{
    protected $varianceService;

    public function __construct(VarianceService $varianceService)
    {
        $this->varianceService = $varianceService;
    }

    /**
     * Calculate variance and refresh the page.
     */
    public function calculate($shiftId): RedirectResponse
    {
        try {
            $result = $this->varianceService->calculateVariance($shiftId);
            return redirect()->back()->with('success', 'Variance calculated successfully. Difference: ' . $result['variance']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error calculating variance: ' . $e->getMessage());
        }
    }

    /**
     * Save the explanation for a shortage/excess.
     */
    public function explain(ExplainVarianceRequest $request, $shiftId): RedirectResponse
    {
        try {
            $this->varianceService->explainVariance($shiftId, $request->explanation);
            return redirect()->back()->with('success', 'Variance explanation recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save explanation: ' . $e->getMessage());
        }
    }

    /**
     * Approve the variance (Manager Action).
     */
    public function approve(Request $request, $shiftId): RedirectResponse
    {
        try {
            $this->varianceService->approveVariance($shiftId, Auth::id());
            return redirect()->back()->with('success', 'Variance has been approved.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function getDetails($shiftId)
    {
        $shift = Shift::findOrFail($shiftId);
        return view('admin.petro.settlement.variance-details', compact('shift'));
    }
}