<?php

namespace App\Repositories;

use App\Interfaces\PumperRepositoryInterface;
use App\Models\CashDrop;
use App\Models\Pump;
use App\Models\PumperLedger;
use App\Models\PumpOperatorAssignment;
use App\Models\Sale;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PumperRepository implements PumperRepositoryInterface
{
    public function getActiveShift()
    {
        return Shift::where('status', 'open')->latest()->first();
    }

    public function getBusyPumperIds()
    {
        return PumpOperatorAssignment::where('status', 'active')
            ->pluck('user_id')
            ->toArray();
    }

    public function getAvailablePumpers(array $busyIds)
    {
        return User::where('role_id', 3)
            ->where('is_active', 1)
            ->whereNotIn('id', $busyIds)
            ->get();
    }

    public function getActiveAssignments()
    {
        return PumpOperatorAssignment::where('status', 'active')
            ->with(['pumper', 'pump'])
            ->get();
    }

    public function getPumperStats($shiftId)
    {
        return DB::table('pump_operator_assignments as poa')
            ->leftJoin('users', 'users.id', '=', 'poa.user_id')
            ->leftJoin('pumps', 'pumps.id', '=', 'poa.pump_id')
            ->select(
                'users.name as pumper_name',
                'users.id as pumper_id',
                'pumps.pump_name',
                'pumps.id as pump_id',
                'poa.status',
                'poa.opening_reading',
                'poa.id as assignment_id'
            )
            ->where('poa.shift_id', $shiftId)
            ->get();
    }

    public function getAvailablePumps(array $assignedPumpIds)
    {
        return Pump::whereNotIn('id', $assignedPumpIds)
            ->where('status', 'active')
            ->get();
    }

    public function createAssignment(array $data)
    {
        return PumpOperatorAssignment::create($data);
    }

    public function findAssignment(int $id)
    {
        return PumpOperatorAssignment::with(['pumper', 'pump.tank', 'shift'])->findOrFail($id);
    }

    public function updateAssignment(int $id, array $data)
    {
        $assignment = PumpOperatorAssignment::findOrFail($id);
        $assignment->update($data);
        return $assignment;
    }


    public function createCashDrop(array $data)
    {
        return CashDrop::create($data);
    }

    public function getLatestLedgerBalance(int $userId)
    {
        return PumperLedger::where('user_id', $userId)
            ->latest()
            ->value('running_balance') ?? 0;
    }

    public function createLedgerEntry(array $data)
    {
        return PumperLedger::create($data);
    }

    public function getLedgerHistory(int $userId)
    {
        return PumperLedger::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }



    public function getSalesForAssignment($assignment)
    {
        return Sale::where('shift_id', $assignment->shift_id)
            ->where('pump_id', $assignment->pump_id)
            ->where('created_by', $assignment->user_id)
            ->sum('amount');
    }

    public function getCashDropsForAssignment($assignment)
    {
        return CashDrop::where('shift_id', $assignment->shift_id)
            ->where('user_id', $assignment->user_id)
            ->get();
    }
}