<?php

namespace App\Services;

use App\Interfaces\TankRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class TankService
{
    protected $repository;

    public function __construct(TankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTanks(array $filters)
    {
        return $this->repository->getAll($filters);
    }

    public function getTankById(int $id)
    {
        return $this->repository->find($id);
    }

    public function createTank(array $data)
    {
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

    /**
     * Handle business logic for stock adjustment
     */
    public function adjustStock(int $id, float $quantity, string $type, string $reason)
    {
        return DB::transaction(function () use ($id, $quantity, $type, $reason) {
            $tank = $this->repository->find($id);
            
            $newStock = $tank->current_stock;

            if ($type === 'add') {
                $newStock += $quantity;
            } elseif ($type === 'subtract') {
                $newStock -= $quantity;
            }

            // Prevent negative stock
            if ($newStock < 0) {
                throw new Exception("Stock cannot be negative.");
            }

            // Prevent exceeding capacity
            if ($newStock > $tank->capacity) {
                throw new Exception("Adjustment exceeds tank capacity.");
            }

            // 1. Update the tank
            $updatedTank = $this->repository->updateCurrentStock($id, $newStock);

            // 2. Here you would logically create a log entry in a History table
            // StockHistory::create([...]); 

            return $updatedTank;
        });
    }
}