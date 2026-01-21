<?php

namespace App\Services;

use App\Interfaces\ShiftRepositoryInterface;
use App\Models\FuelPrice;
use App\Models\Pump;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShiftService
{
    protected $repository;

    public function __construct(ShiftRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllShifts(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function getShiftById(int $id)
    {
        return $this->repository->find($id);
    }

    public function openShift(array $data)
    {

        $existing = $this->repository->findActiveShift($data['station_id']);
        if ($existing) {
            throw new \Exception('A shift is already open! Please close it first.');
        }

        $date = now()->format('Ymd');
        $count = $this->repository->countShiftsForDate(now()) + 1;
        $shiftNumber = 'SH-'.$date.'-'.$count;

        $shiftData = [
            'shift_number' => $shiftNumber,
            'station_id' => $data['station_id'],
            'user_id' => Auth::id(),
            'shift_date' => now()->toDateString(),
            'start_time' => now(),
            'status' => 'open',
            'opening_cash' => $data['opening_cash'],
            'total_sales' => 0,
        ];

        return $this->repository->create($shiftData);
    }

    public function recordReading(array $data)
    {
        return DB::transaction(function () use ($data) {
            $shift = $this->repository->find($data['shift_id']);
            $pump = Pump::with('tank')->findOrFail($data['pump_id']);

            $start = $pump->current_reading;
            $end = $data['end_reading'];
            $vol = $end - $start;

            if ($vol < 0) {
                throw new \Exception('Closing reading cannot be less than opening reading.');
            }

            $fuelPrice = FuelPrice::where('fuel_type_id', $pump->tank->fuel_type_id ?? 0)
                ->where('station_id', $shift->station_id)
                ->whereDate('effective_from', '<=', now())
                ->orderBy('effective_from', 'desc')
                ->first();

            $price = $fuelPrice->selling_price ?? 0;
            $amount = $vol * $price;

            Sale::create([
                'sale_number' => 'SALE-'.date('Ymd-His').'-'.rand(100, 999),
                'shift_id' => $shift->id,
                'station_id' => $shift->station_id,
                'pump_id' => $pump->id,
                'fuel_type_id' => $pump->tank->fuel_type_id ?? 1,
                'start_reading' => $start,
                'end_reading' => $end,
                'quantity' => $vol,
                'rate' => $price,
                'amount' => $amount,
                'final_amount' => $amount,
                'status' => 'completed',
                'payment_mode' => 'cash',
                'sale_datetime' => now(),
                'created_by' => Auth::id(),
            ]);

            $pump->update(['current_reading' => $end]);

            if ($pump->tank) {
                $pump->tank->decrement('current_stock', $vol);
            }

            return true;
        });
    }

    public function closeShift(int $id, float $closingCash, ?string $notes)
    {
        $shift = $this->repository->find($id);

        if ($shift->status !== 'open') {
            throw new \Exception('This shift is not open.');
        }

        $activeDuties = \App\Models\PumpOperatorAssignment::where('shift_id', $id)
            ->where('status', 'active')
            ->count();

        if ($activeDuties > 0) {
            throw new \Exception("Cannot close shift. There are $activeDuties active pumpers still working. Please close their duties first.");
        }

        $unsettledCount = \App\Models\PumpOperatorAssignment::where('shift_id', $id)
            ->where('status', 'pending_settlement')
            ->count();

        if ($unsettledCount > 0) {
            $systemNote = " [System Warning: Closed with $unsettledCount unsettled pumper shortages]";
            $notes .= $systemNote;
        }

        $totalSales = $shift->sales()->sum('amount');
        $expectedCash = $shift->opening_cash + $totalSales;
        $variance = $closingCash - $expectedCash;

        $shift = $this->repository->update($id, [
            'status' => 'closed',
            'end_time' => now(),
            'total_sales' => $totalSales,
            'closing_cash' => $closingCash,
            'expected_cash' => $expectedCash,
            'cash_variance' => $variance,
            'closing_notes' => $notes,
            'closed_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return (object) ['shift' => $shift, 'unsettled_count' => $unsettledCount];
    }

    public function deleteSale($id)
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::findOrFail($id);
            $pump = Pump::find($sale->pump_id);

            if ($pump) {
                $pump->decrement('current_reading', $sale->quantity);
            }

            if ($pump && $pump->tank) {
                $pump->tank->increment('current_stock', $sale->quantity);
            }

            $sale->delete();

            return true;
        });
    }
}
