<?php

namespace App\Services;

use App\Models\Shift;

class ShiftService
{
    public function getAllShifts(array $filters = [])
    {
        $query = Shift::latest();

        if (isset($filters['station_id'])) {
            $query->where('station_id', $filters['station_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function openShift(array $data)
    {
        // Check active
        $active = Shift::where('station_id', $data['station_id'])
            ->where('status', 'open')
            ->first();

        if ($active) {
            throw new \Exception("Shift already open");
        }

        $count = Shift::where('station_id', $data['station_id'])->count() + 1;

        return Shift::create([
            'station_id' => $data['station_id'],
            'start_time' => now()->toTimeString(),
            'shift_date' => now()->toDateString(),
            'shift_number' => 'SH-' . date('Ymd') . '-' . $count,
            'status' => 'open',
            'opening_cash' => $data['opening_cash'],
            'user_id' => auth()->id()
        ]);
    }

    public function closeShift($id, $closingCash)
    {
        $shift = Shift::find($id);

        if (!$shift || $shift->status != 'open') {
            throw new \Exception("Invalid shift");
        }

        $sales = $shift->sales()->where('is_voided', false)->get();
        // $totalSales = $sales->sum('final_amount'); // Not needed if we trust updated column

        // Calculate expected cash
        $expectedCash = $shift->opening_cash + $sales->where('payment_mode', 'cash')->sum('final_amount');
        $variance = $closingCash - $expectedCash;

        $shift->update([
            'status' => 'closed',
            'end_time' => now()->toTimeString(),
            'closing_cash' => $closingCash,
            'cash_variance' => $variance,
            'closed_by' => auth()->id()
        ]);

        return $shift;
    }

    public function getShiftById($id)
    {
        return Shift::find($id);
    }
}
