<?php

namespace App\Repositories;

use App\Models\Tank;
use App\Interfaces\TankRepositoryInterface;

class TankRepository implements TankRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Tank::query();

        if (isset($filters['fuel_type'])) {
            $query->where('fuel_type', $filters['fuel_type']);
        }

        // For Web, we usually want pagination instead of getting all records
        return $query->latest()->paginate(22);
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
        $tank = $this->find($id);
        $tank->update($data);
        return $tank;
    }

    public function delete(int $id)
    {
        $tank = $this->find($id);
        return $tank->delete();
    }

    public function updateCurrentStock(int $id, float $newLevel)
    {
        $tank = $this->find($id);
        $tank->current_stock = $newLevel;
        $tank->save();
        return $tank;
    }
}