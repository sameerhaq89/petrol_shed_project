<?php

namespace App\Services;

use App\Interfaces\PumperRepositoryInterface;
use App\Models\FuelPrice;
use App\Models\Pump;
use App\Models\PumpReading;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PumperService
{
    protected $repository;

    public function __construct(PumperRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getDashboardData()
    {
        $activeShift = $this->repository->getActiveShift();
        $busyPumperIds = $this->repository->getBusyPumperIds();
        $pumpers = $this->repository->getAvailablePumpers($busyPumperIds);
        $activeAssignments = $this->repository->getActiveAssignments();

        $pumperStats = $activeShift
            ? $this->repository->getPumperStats($activeShift->id)
            : collect([]);

        $assignedPumpIds = $activeAssignments->pluck('pump_id')->toArray();
        $availablePumps = $this->repository->getAvailablePumps($assignedPumpIds);

        return compact('activeShift', 'pumpers', 'pumperStats', 'availablePumps');
    }

    public function assignPumper(array $data)
    {
        $activeShift = $this->repository->getActiveShift();
        if (!$activeShift) {
            throw new \Exception('No Main Shift is Open!');
        }

        $pump = Pump::find($data['pump_id']);

        $latestMeter = Sale::where('pump_id', $data['pump_id'])
            ->latest('end_reading')
            ->value('end_reading') ?? $pump->current_reading;

        if ($pump->current_reading < $latestMeter) {
            $pump->update(['current_reading' => $latestMeter]);
        }

        return $this->repository->createAssignment([
            'shift_id' => $activeShift->id,
            'user_id' => $data['user_id'],
            'pump_id' => $data['pump_id'],
            'start_time' => now(),
            'opening_reading' => $latestMeter,
            'opening_cash' => $data['opening_cash'] ?? 0,
            'status' => 'active',
        ]);
    }

    public function getCloseDutyData($assignmentId)
    {
        $assignment = $this->repository->findAssignment($assignmentId);

        // 1. Calculate Total Cash Drops (Mid-shift only)
        $totalDrops = $this->repository->getCashDropsForAssignment($assignment)
            ->filter(function ($drop) {
                $note = $drop->notes;
                return is_null($note) || (stripos($note, 'Final Settlement') === false && stripos($note, 'Shortage Settlement') === false);
            })
            ->sum('amount');

        // 2. Get Current Price
        $fuelTypeId = $assignment->pump->fuel_type_id ?? $assignment->pump->tank->fuel_type_id ?? 1;
        $priceRecord = FuelPrice::where('station_id', $assignment->shift->station_id)
            ->where('fuel_type_id', $fuelTypeId)
            ->orderBy('created_at', 'desc')
            ->first();
        $currentPrice = $priceRecord ? $priceRecord->selling_price : 0;

        return compact('assignment', 'totalDrops', 'currentPrice');
    }

    public function closeDuty(int $assignmentId, float $closingReading, float $closingCashReceived)
    {
        return DB::transaction(function () use ($assignmentId, $closingReading, $closingCashReceived) {
            $assignment = $this->repository->findAssignment($assignmentId);

            $fuelTypeId = $assignment->pump->fuel_type_id ?? $assignment->pump->tank->fuel_type_id ?? 1;
            $stationId = $assignment->shift->station_id;

            $lastRecordedMeter = Sale::where('shift_id', $assignment->shift_id)
                ->where('pump_id', $assignment->pump_id)
                ->max('end_reading') ?? $assignment->opening_reading;

            $soldQty = $closingReading - $lastRecordedMeter;

            $priceRecord = FuelPrice::where('station_id', $stationId)
                ->where('fuel_type_id', $fuelTypeId)
                ->orderBy('created_at', 'desc')
                ->first();
            $price = $priceRecord ? $priceRecord->selling_price : 0;
            $totalAmount = $soldQty * $price;

            if ($soldQty > 0) {
                Sale::create([
                    'shift_id' => $assignment->shift_id,
                    'station_id' => $stationId,
                    'pump_id' => $assignment->pump_id,
                    'fuel_type_id' => $fuelTypeId,
                    'sale_number' => 'SL-' . time(),
                    'created_by' => $assignment->user_id,
                    'start_reading' => $lastRecordedMeter,
                    'end_reading' => $closingReading,
                    'quantity' => $soldQty,
                    'rate' => $price,
                    'amount' => $totalAmount,
                    'final_amount' => $totalAmount,
                    'sale_datetime' => now(),
                    'status' => 'completed',
                    'payment_mode' => 'cash',
                ]);
                $assignment->shift->increment('total_sales', $totalAmount);

                // Decrement Tank Stock
                if ($assignment->pump->tank_id) {
                    $tank = \App\Models\Tank::find($assignment->pump->tank_id);
                    if ($tank) {
                        $tank->decrement('current_stock', $soldQty);

                        // Optional: Record element in StockMovement if you have that table
                        \App\Models\StockMovement::create([
                            'tank_id' => $tank->id,
                            'type' => 'sales',
                            'quantity' => $soldQty,
                            'balance_after' => $tank->current_stock,
                            'reference_type' => 'shift', // or 'assignment'
                            'reference_id' => $assignment->shift_id,
                            'recorded_at' => now(),
                        ]);
                    }
                }
            }

            $midShiftDrops = $this->repository->getCashDropsForAssignment($assignment)
                ->filter(function ($drop) {
                    $note = $drop->notes;
                    return is_null($note) || (stripos($note, 'Final Settlement') === false && stripos($note, 'Shortage Settlement') === false);
                })
                ->sum('amount');

            $totalSalesAmount = $this->repository->getSalesForAssignment($assignment);
            $openingCash = $assignment->shift->opening_cash ?? 0;

            $pumperFloat = $assignment->opening_cash ?? 0;

            $expectedTotal = $totalSalesAmount + $pumperFloat;
            $actualReceived = $midShiftDrops + $closingCashReceived;
            $variance = $actualReceived - $expectedTotal;
            $finalStatus = ($variance < -1) ? 'pending_settlement' : 'completed';

            $this->repository->updateAssignment($assignmentId, [
                'closing_reading' => $closingReading,
                'closing_cash_received' => $closingCashReceived,
                'end_time' => now(),
                'status' => $finalStatus,
            ]);

            $assignment->pump->update(['current_reading' => $closingReading]);

            $this->syncMasterReadings($assignment, $closingReading, $price);

            if ($closingCashReceived > 0) {
                $this->repository->createCashDrop([
                    'shift_id' => $assignment->shift_id,
                    'user_id' => $assignment->user_id,
                    'amount' => $closingCashReceived,
                    'notes' => 'Final Settlement (Meter: ' . $closingReading . ')',
                    'dropped_at' => now(),
                    'status' => 'pending',
                ]);
            }

            if ($variance < -1) {
                $lastBalance = $this->repository->getLatestLedgerBalance($assignment->user_id);
                $this->repository->createLedgerEntry([
                    'user_id' => $assignment->user_id,
                    'assignment_id' => $assignment->id,
                    'type' => 'shortage',
                    'amount' => abs($variance),
                    'running_balance' => $lastBalance + abs($variance),
                    'remarks' => 'Shortage from Shift ' . $assignment->shift->shift_number,
                ]);
            }

            return $finalStatus;
        });
    }

    public function settleShortage(int $assignmentId, float $amount)
    {
        return DB::transaction(function () use ($assignmentId, $amount) {
            $assignment = $this->repository->findAssignment($assignmentId);

            $this->repository->createCashDrop([
                'shift_id' => $assignment->shift_id,
                'user_id' => $assignment->user_id,
                'amount' => $amount,
                'notes' => 'Shortage Settlement (Manual)',
                'dropped_at' => now(),
                'status' => 'pending',
            ]);

            $lastBalance = $this->repository->getLatestLedgerBalance($assignment->user_id);
            $this->repository->createLedgerEntry([
                'user_id' => $assignment->user_id,
                'assignment_id' => $assignment->id,
                'type' => 'payment',
                'amount' => $amount,
                'running_balance' => $lastBalance - $amount,
                'remarks' => 'Payment received for Shift ' . $assignment->shift_id,
            ]);

            $assignment->update(['status' => 'completed']);

            return $amount;
        });
    }

    public function getLedgerData(int $pumperId)
    {
        $pumper = User::findOrFail($pumperId);
        $entries = $this->repository->getLedgerHistory($pumperId);
        $currentBalance = $entries->first()->running_balance ?? 0;

        return compact('pumper', 'entries', 'currentBalance');
    }

    private function syncMasterReadings($assignment, $endReading, $price)
    {
        $pumpReading = PumpReading::where('shift_id', $assignment->shift_id)
            ->where('pump_id', $assignment->pump_id)
            ->first();

        if ($pumpReading) {
            $newTotalVol = $endReading - $pumpReading->opening_reading;
            $pumpReading->update([
                'closing_reading' => $endReading,
                'total_volume' => $newTotalVol,
                'total_amount' => $newTotalVol * $price,
            ]);
        } else {
            PumpReading::create([
                'shift_id' => $assignment->shift_id,
                'pump_id' => $assignment->pump_id,
                'opening_reading' => $assignment->opening_reading,
                'closing_reading' => $endReading,
                'total_volume' => $endReading - $assignment->opening_reading,
                'current_price' => $price,
                'total_amount' => ($endReading - $assignment->opening_reading) * $price,
            ]);
        }
    }
}
