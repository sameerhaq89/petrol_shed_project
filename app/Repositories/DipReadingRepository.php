<?php

namespace App\Repositories;

use App\Interfaces\DipReadingRepositoryInterface;
use App\Models\DipReading;
use Illuminate\Support\Facades\Auth;

class DipReadingRepository implements DipReadingRepositoryInterface
{
    public function getAll()
    {
        return DipReading::with(['tank', 'tank.fuelType', 'recorder'])
            ->latest()
            ->get();
    }

    public function find(int $id)
    {
        return DipReading::findOrFail($id);
    }

    public function create(array $data)
    {
        $stationId = Auth::user()->station_id ?? 1;

        return DipReading::create([
            'station_id'    => $stationId,
            'tank_id'       => $data['tank_id'],
            'reading_date'  => $data['reading_date'],
            'dip_level_cm'  => $data['dip_level_cm'],
            'volume_liters' => $data['volume_liters'],
            'temperature'   => $data['temperature'] ?? null,
            'notes'         => $data['notes'] ?? null,
            'recorded_by'   => Auth::id()
        ]);
    }

    public function update(int $id, array $data)
    {
        $dip = DipReading::findOrFail($id);
        $dip->update($data);
        return $dip;
    }

    public function delete(int $id)
    {
        $dip = DipReading::findOrFail($id);
        return $dip->delete();
    }

    /**
     * Get the absolute latest reading for a tank (by date, then ID)
     */
    public function getLatestForTank(int $tankId)
    {
        return DipReading::where('tank_id', $tankId)
            ->orderBy('reading_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Get the "previous" reading (ignoring a specific ID).
     * Used when deleting the latest record.
     */
    public function getSecondLatestForTank(int $tankId, int $excludeId)
    {
        return DipReading::where('tank_id', $tankId)
            ->where('id', '!=', $excludeId)
            ->orderBy('reading_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();
    }
}