<?php

namespace App\Repositories;

use App\Interfaces\FuelPriceRepositoryInterface;
use App\Models\FuelPrice;
use Illuminate\Support\Facades\Auth;

class FuelPriceRepository implements FuelPriceRepositoryInterface
{

    public function getAllActivePrices()
    {
        $stationId = Auth::user()->station_id ?? 1;

        return FuelPrice::with('fuelType')
            ->where('station_id', $stationId)
            ->whereNull('effective_to')
            ->get();
    }

   
    public function getHistory()
    {
        $stationId = Auth::user()->station_id ?? 1;

        return FuelPrice::with(['fuelType', 'creator'])
            ->where('station_id', $stationId)
            ->orderBy('effective_from', 'desc')
            ->get();
    }

  
    public function getActivePrice(int $fuelTypeId, int $stationId)
    {
        return FuelPrice::where('fuel_type_id', $fuelTypeId)
            ->where('station_id', $stationId)
            ->whereNull('effective_to')
            ->latest('effective_from')
            ->first();
    }

    public function find(int $id)
    {
        return FuelPrice::findOrFail($id);
    }

    public function create(array $data)
    {
        return FuelPrice::create($data);
    }

    public function update(int $id, array $data)
    {
        $price = FuelPrice::findOrFail($id);
        $price->update($data);
        return $price;
    }

    public function delete(int $id)
    {
        $price = FuelPrice::findOrFail($id);
        return $price->delete();
    }
}