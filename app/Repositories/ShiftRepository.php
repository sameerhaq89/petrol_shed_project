<?php

namespace App\Repositories;

use App\Interfaces\ShiftRepositoryInterface;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class ShiftRepository implements ShiftRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Shift::with(['station', 'user'])->latest();

        // Filter by Station (Role Security)
        if (Auth::check() && Auth::user()->role_id !== 1) {
            $query->where('station_id', Auth::user()->station_id);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(int $id)
    {
        return Shift::with(['station', 'cashDrops', 'sales.pump.tank.fuelType'])->findOrFail($id);
    }

    public function findActiveShift(int $stationId)
    {
        return Shift::where('station_id', $stationId)
            ->where('status', 'open')
            ->latest()
            ->first();
    }

    public function create(array $data)
    {
        return Shift::create($data);
    }

    public function update(int $id, array $data)
    {
        $shift = Shift::findOrFail($id);
        $shift->update($data);
        return $shift;
    }

    public function delete(int $id)
    {
        $shift = Shift::findOrFail($id);
        return $shift->delete();
    }

    public function countShiftsForDate($date)
    {
        return Shift::whereDate('created_at', $date)->count();
    }
}