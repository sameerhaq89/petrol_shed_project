<?php

namespace App\Repositories;

use App\Models\CashDrop;
use App\Repositories\Interfaces\CashDropRepositoryInterface;

class CashDropRepository implements CashDropRepositoryInterface
{
    public function getByShift(int $shiftId)
    {
        return CashDrop::where('shift_id', $shiftId)
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        return CashDrop::create($data);
    }

    public function find(int $id)
    {
        return CashDrop::findOrFail($id);
    }

    public function markAsVerified(int $id)
    {
        $drop = $this->find($id);
        $drop->update(['verified_at' => now()]);
        return $drop;
    }
}