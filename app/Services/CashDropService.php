<?php

namespace App\Services;

use App\Models\CashDrop;
use App\Models\Shift;

class CashDropService
{
    public function getDropsByShift($shiftId)
    {
        return CashDrop::with(['user', 'receiver'])
            ->where('shift_id', $shiftId)
            ->latest()
            ->get();
    }

    public function createDrop(array $data)
    {
        $shift = Shift::where('station_id', $data['station_id'])
            ->where('status', 'open')
            ->first();

        if (!$shift) {
            throw new \Exception("No active shift found");
        }

        return CashDrop::create([
            'shift_id' => $shift->id,
            'user_id' => auth()->id() ?? 1,
            'amount' => $data['amount'],
            'dropped_at' => now(),
            'status' => 'pending',
            'notes' => $data['notes'] ?? null
        ]);
    }

    public function verifyDrop($id)
    {
        $drop = CashDrop::find($id);
        if (!$drop) {
            throw new \Exception("Drop not found");
        }

        $drop->update([
            'status' => 'verified',
            'received_by' => auth()->id()
        ]);

        return $drop;
    }
}
