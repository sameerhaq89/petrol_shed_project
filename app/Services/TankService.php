<?php

namespace App\Services;

use App\Interfaces\TankRepositoryInterface;
use App\Models\Station;
use App\Models\Tank;
use Illuminate\Support\Facades\Auth;

class TankService
{
    protected $repository;

    public function __construct(TankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTanks(array $filters = [])
{
    $query = Tank::with(['fuelType', 'station']);

    // LOGIC UPDATE:
    // If I am NOT a Super Admin (Role 1), restrict me to my station.
    if (Auth::check() && Auth::user()->role_id !== 1) {
        $query->where('station_id', Auth::user()->station_id);
    }

    return $query->latest()->get();
}

    public function getTankById(int $id)
    {
        return $this->repository->find($id);
    }

    public function createTank(array $data)
    {
        // Auto-assign station ID
        $stationId = Auth::user()->station_id;

        // Fallback for Super Admin
        if (!$stationId && Auth::user()->role_id == 1) {
            $stationId = $data['station_id'] ?? Station::first()->id ?? 1;
        }

        // Prepare data for repository
        $data['station_id'] = $stationId;
        $data['current_stock'] = $data['current_stock'] ?? 0;
        
        // If status wasn't passed, default to active
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        return $this->repository->create($data);
    }

    public function updateTank(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteTank(int $id)
    {
        return $this->repository->delete($id);
    }

    public function adjustStock($tankId, $quantity, $type, $reason = null)
    {
        $tank = $this->repository->find($tankId);

        if ($type === 'refill') {
            $tank->current_stock += $quantity;
        } else {
            // Dip or Correction overrides the value
            $tank->current_stock = $quantity;
        }

        $tank->save();
        return $tank;
    }
}