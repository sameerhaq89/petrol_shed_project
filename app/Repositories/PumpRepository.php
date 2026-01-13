<?php

namespace App\Repositories;

use App\Models\Pump;
use App\Interfaces\PumpRepositoryInterface;

class PumpRepository implements PumpRepositoryInterface
{
    public function getAll()
    {
        // Eager load 'tank' to get fuel type info efficiently
        return Pump::with('tank')->latest()->get();
    }

    public function find(int $id)
    {
        return Pump::findOrFail($id);
    }

    public function create(array $data)
    {
        return Pump::create($data);
    }

    public function update(int $id, array $data)
    {
        $pump = $this->find($id);
        $pump->update($data);
        return $pump;
    }

    public function delete(int $id)
    {
        $pump = $this->find($id);
        return $pump->delete();
    }
}