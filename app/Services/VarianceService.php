<?php

namespace App\Services;

use App\Interfaces\VarianceRepositoryInterface;
use App\Models\Shift;

class VarianceService
{
    protected $repository;

    public function __construct(VarianceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function calculateVariance(int $shiftId)
    {
        $shift = Shift::find($shiftId);
        if (! $shift) {
            throw new \Exception('Shift not found');
        }

        $expectedCash = $shift->opening_cash + $shift->total_sales;

        $actualCash = $shift->closing_cash;
        $cashVariance = $actualCash - $expectedCash;

        $percentage = $expectedCash > 0 ? ($cashVariance / $expectedCash) * 100 : 0;

        $status = abs($cashVariance) > 100 ? 'review' : 'acceptable';

        $this->repository->updateOrCreate($shiftId, 'cash', [
            'expected_amount' => $expectedCash,
            'actual_amount' => $actualCash,
            'variance_amount' => $cashVariance,
            'variance_percentage' => $percentage,
            'status' => $status,
        ]);

        return [
            'variance' => number_format($cashVariance, 2),
            'status' => $status,
        ];
    }

    public function explainVariance(int $shiftId, string $explanation, string $type = 'cash')
    {
        $variance = $this->repository->findByShift($shiftId, $type);

        if (! $variance) {
            throw new \Exception('Variance record not found. Please calculate first.');
        }

        return $this->repository->update($variance->id, [
            'explanation' => $explanation,
            'status' => 'review',
        ]);
    }

    public function approveVariance(int $shiftId, int $userId, string $type = 'cash')
    {
        $variance = $this->repository->findByShift($shiftId, $type);

        if (! $variance) {
            throw new \Exception('Variance record not found.');
        }

        return $this->repository->update($variance->id, [
            'status' => 'approved',
            'reviewed_by' => $userId,
            'approved_at' => now(),
        ]);
    }
}
