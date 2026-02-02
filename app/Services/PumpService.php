<?php

namespace App\Services;

use App\Interfaces\PumpRepositoryInterface;

class PumpService
{
    protected $repository;

    public function __construct(PumpRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPumpsForDashboard()
    {
        // Filter by the user's active station ID (set by Station Switcher), regardless of role.
        $stationId = \Illuminate\Support\Facades\Auth::user()->station_id;
        // Assuming the repository methods don't support filters easily, we filter the collection or query
        // But since we can't see the repository, we'll assume we might need to adjust logic there or here.
        // Wait, the repository->getAll() usually returns all. We should check if we can filter.
        // Given constraints, let's assume we can filter on the collection returned, OR if the repository uses a model, we can add a global scope or specific where.

        // BETTER APPROACH: Use the same pattern as TankService: manually query if repository doesn't support it, OR assume repository returns Model query builder. 
        // Let's assume the repository returns a Collection currently based on 'all()'.
        // If it returns a collection, we can filter it.
        $pumps = \App\Models\Pump::with(['tank.fuelType', 'station'])
            ->where('station_id', $stationId)
            ->get();

        return $pumps->map(function ($pump) {
            $statusData = $this->getStatusDetails($pump->status);

            return [
                'id' => $pump->id,
                'pumpName' => $pump->pump_name ?? $pump->pump_number,
                'pumpType' => $pump->tank ? $pump->tank->tank_name : 'No Tank',
                'currentMeter' => number_format($pump->current_reading ?? 0, 2) . ' L',
                'statusIcon' => $statusData['icon'],
                'statusColor' => $statusData['color'],
                'isActive' => $pump->status === 'active',
                'linkStatus' => $pump->tank ? 'Linked to ' . $pump->tank->tank_name : 'Unlinked',
            ];
        });
    }

    public function getPumpsForManagementTable()
    {
        $stationId = \Illuminate\Support\Facades\Auth::user()->station_id;
        $pumps = \App\Models\Pump::with(['tank.fuelType'])
            ->where('station_id', $stationId)
            ->get();

        return $pumps->map(function ($pump) {
            $productName = $pump->tank && $pump->tank->fuelType ? $pump->tank->fuelType->name : 'N/A';
            $tankName = $pump->tank ? $pump->tank->tank_name : 'Unassigned';

            return [
                'id' => $pump->id,
                'date' => $pump->created_at->format('Y-m-d'),
                'transaction_date' => $pump->updated_at->format('Y-m-d H:i'),
                'pump_no' => $pump->pump_number,
                'name' => $pump->pump_name,
                'start_meter' => number_format($pump->opening_reading, 2),
                'close_meter' => number_format($pump->current_reading, 2),
                'product_name' => $productName,
                'fuel_tanks' => $tankName,
                'tank_id' => $pump->tank_id,
                'status' => $pump->status,
            ];
        });
    }

    public function createPump(array $data)
    {
        return $this->repository->create($data);
    }

    public function updatePump(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deletePump(int $id)
    {
        return $this->repository->delete($id);
    }

    public function getPumpById(int $id)
    {
        return $this->repository->find($id);
    }

    private function getStatusDetails($status)
    {
        return match ($status) {
            'active' => ['icon' => 'check-circle', 'color' => 'success'],
            'maintenance' => ['icon' => 'wrench',       'color' => 'warning'],
            'offline' => ['icon' => 'power-off',    'color' => 'danger'],
            default => ['icon' => 'help-circle',  'color' => 'secondary'],
        };
    }
}
