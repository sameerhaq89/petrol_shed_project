<?php

namespace App\Repositories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Collection;

class ShiftRepository
{
    public function findActiveShift(int $stationId): ?Shift
    {
        return Shift::where('station_id', $stationId)->where('status', 'open')->first();
    }

    public function create(array $data): Shift
    {
        return Shift::create($data);
    }

    public function updateSalesTotals(Shift $shift): void
    {
        // Recalculate sales totals
        $sales = $shift->sales()->where('is_voided', false)->get();

        $shift->update([
            'cash_sales' => $sales->where('payment_mode', 'cash')->sum('final_amount'),
            'card_sales' => $sales->where('payment_mode', 'card')->sum('final_amount'),
            'credit_sales' => $sales->where('payment_mode', 'credit')->sum('final_amount'),
            'upi_sales' => $sales->where('payment_mode', 'upi')->sum('final_amount'),
            'total_sales_amount' => $sales->sum('final_amount')
        ]);
    }
}
