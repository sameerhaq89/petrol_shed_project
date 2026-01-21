<?php

namespace App\Interfaces;

interface FuelPriceRepositoryInterface
{
    public function getAllActivePrices();
    public function getHistory();
    public function getActivePrice(int $fuelTypeId, int $stationId);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}