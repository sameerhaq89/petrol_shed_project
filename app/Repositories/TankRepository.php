<?php

namespace App\Repositories;

use App\Interfaces\TankRepositoryInterface;
use App\Models\Tank;

class TankRepository implements TankRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Tank::with(['fuelType', 'station']);

        // Filter by Fuel Type
        if (isset($filters['fuel_type_id'])) {
            $query->where('fuel_type_id', $filters['fuel_type_id']);
        }

        // Filter by Station
        if (isset($filters['station_id'])) {
            $query->where('station_id', $filters['station_id']);
        }

        return $query->latest()->get();
    }

    public function find(int $id)
    {
        return Tank::findOrFail($id);
    }

    public function create(array $data)
    {
        return Tank::create($data);
    }

    public function update(int $id, array $data)
    {
        $tank = Tank::findOrFail($id);
        $tank->update($data);
        return $tank;
    }

    public function delete(int $id)
    {
        $tank = Tank::findOrFail($id);
        return $tank->delete();
    }

    public function updateCurrentStock(int $id, float $newStock)
    {
        $tank = Tank::findOrFail($id);
        $tank->current_stock = $newStock;
        $tank->save();
        return $tank;
    }
}