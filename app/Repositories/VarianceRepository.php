<?php

namespace App\Repositories;

use App\Interfaces\VarianceRepositoryInterface;
use App\Models\ShiftVariance;

class VarianceRepository implements VarianceRepositoryInterface
{
    public function findByShift(int $shiftId, string $type = 'cash')
    {
        return ShiftVariance::where('shift_id', $shiftId)
            ->where('variance_type', $type)
            ->first();
    }

    public function updateOrCreate(int $shiftId, string $type, array $data)
    {
        return ShiftVariance::updateOrCreate(
            ['shift_id' => $shiftId, 'variance_type' => $type],
            $data
        );
    }

    public function update(int $id, array $data)
    {
        $variance = ShiftVariance::findOrFail($id);
        $variance->update($data);
        return $variance;
    }
}