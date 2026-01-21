<?php

namespace App\Repositories;

use App\Models\CashDrop;
use App\Interfaces\CashDropRepositoryInterface;

class CashDropRepository implements CashDropRepositoryInterface
{
    public function getByShift(int $shiftId)
    {
        return CashDrop::with(['user', 'receiver'])
            ->where('shift_id', $shiftId)
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

    public function verify(int $id, int $receiverId)
    {
        $drop = $this->find($id);
        $drop->update([
            'status' => 'verified',
            'received_by' => $receiverId,
            // 'verified_at' => now(), // Column does not exist
        ]);
        return $drop;
    }

    public function delete(int $id)
    {
        $drop = $this->find($id);
        return $drop->delete();
    }
}