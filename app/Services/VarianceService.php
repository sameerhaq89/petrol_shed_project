<?php

namespace App\Services;

use App\Models\Shift;
use App\Models\ShiftVariance;
use App\Models\Tank;

class VarianceService
{
    public function calculateVariance(int $shiftId)
    {
        $shift = Shift::find($shiftId);
        if (!$shift)
            throw new \Exception("Shift not found");

        // 1. Cash Variance
        // Expected = Opening + Cash Sales
        // Actual = Cash Collected (from closing)
        $expectedCash = $shift->opening_cash + $shift->cash_sales;
        $actualCash = $shift->closing_cash;
        $cashVariance = $actualCash - $expectedCash;
        $percentage = $expectedCash > 0 ? ($cashVariance / $expectedCash) * 100 : 0;

        // Save Cash Variance
        ShiftVariance::updateOrCreate(
            ['shift_id' => $shiftId, 'variance_type' => 'cash'],
            [
                'expected_amount' => $expectedCash,
                'actual_amount' => $actualCash,
                'variance_amount' => $cashVariance,
                'variance_percentage' => $percentage,
                'status' => abs($cashVariance) > 100 ? 'review' : 'acceptable' // tolerance 100
            ]
        );

        return [
            'cash_variance' => $cashVariance,
            'status' => abs($cashVariance) > 100 ? 'Review Needed' : 'OK'
        ];
    }

    public function explainVariance(int $shiftId, string $explanation, ?string $type = 'cash')
    {
        $variance = ShiftVariance::where('shift_id', $shiftId)
            ->where('variance_type', $type)
            ->first();

        if (!$variance) {
            // Create if not exists (though calculate usually runs first)
            // For now throw error or create empty
            throw new \Exception("Variance record not found. Please calculate first.");
        }

        $variance->update([
            'explanation' => $explanation,
            'status' => 'review'
        ]);

        return $variance;
    }

    public function approveVariance(int $shiftId, int $userId, ?string $type = 'cash')
    {
        $variance = ShiftVariance::where('shift_id', $shiftId)
            ->where('variance_type', $type)
            ->first();

        if (!$variance) {
            throw new \Exception("Variance record not found.");
        }

        $variance->update([
            'status' => 'approved',
            'reviewed_by' => $userId,
            'approved_at' => now()
        ]);

        return $variance;
    }
}
