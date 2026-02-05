<?php

namespace App\Repositories;

use App\Interfaces\FuelTypeRepositoryInterface;
use App\Models\FuelType;

class FuelTypeRepository implements FuelTypeRepositoryInterface
{
    public function getAll($stationId = null)
    {
        $query = FuelType::latest();

        if ($stationId) {
            $query->where('station_id', $stationId);
        }

        return $query->get();
    }

    public function find(int $id)
    {
        return FuelType::findOrFail($id);
    }

    public function create(array $data)
    {
        return FuelType::create($data);
    }

    public function update(int $id, array $data)
    {
        $fuelType = FuelType::findOrFail($id);
        $fuelType->update($data);
        return $fuelType;
    }

    public function delete(int $id)
    {
        $fuelType = FuelType::findOrFail($id);
        return $fuelType->delete();
    }
}
