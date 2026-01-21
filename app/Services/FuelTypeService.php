<?php

namespace App\Services;

use App\Interfaces\FuelTypeRepositoryInterface;

class FuelTypeService
{
    protected $repository;

    public function __construct(FuelTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllFuelTypes()
    {
        return $this->repository->getAll();
    }

    public function getFuelTypeById(int $id)
    {
        return $this->repository->find($id);
    }

    public function createFuelType(array $data)
    {
        // Add default active status if not provided
        if (!isset($data['is_active'])) {
            $data['is_active'] = true;
        }
        return $this->repository->create($data);
    }

    public function updateFuelType(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteFuelType(int $id)
    {
        return $this->repository->delete($id);
    }
}