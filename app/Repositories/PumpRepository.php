<?php

namespace App\Repositories;

use App\Interfaces\PumpRepositoryInterface;
use App\Models\Pump;
use Illuminate\Support\Facades\Auth;

class PumpRepository implements PumpRepositoryInterface
{
    public function getAll()
    {

        $stationId = $this->getStationId();
        $query = Pump::with(['tank', 'tank.fuelType']);

        if (Auth::check() && Auth::user()->role_id !== 1) {
            $query->where('station_id', $stationId);
        }

        return $query->latest()->get();
    }

    public function find(int $id)
    {
        return Pump::findOrFail($id);
    }

    public function create(array $data)
    {
        return Pump::create([
            'pump_number' => $data['pump_number'],
            'pump_name' => $data['pump_name'] ?? null,
            'tank_id' => $data['tank_id'],
            'station_id' => $this->getStationId(),
            'opening_reading' => $data['last_meter_reading'] ?? 0,
            'current_reading' => $data['last_meter_reading'] ?? 0,
            'status' => $data['status'] ?? 'active',
            'calibration_frequency_days' => 180,
        ]);
    }

    public function update(int $id, array $data)
    {
        $pump = Pump::findOrFail($id);

        $updateData = [
            'pump_number' => $data['pump_number'],
            'pump_name' => $data['pump_name'] ?? $pump->pump_name,
            'tank_id' => $data['tank_id'],
            'status' => $data['status'] ?? $pump->status,
        ];

        if (isset($data['last_meter_reading'])) {
            $updateData['opening_reading'] = $data['last_meter_reading'];
        }

        $pump->update($updateData);

        return $pump;
    }

    public function delete(int $id)
    {
        $pump = Pump::findOrFail($id);

        return $pump->delete();
    }

    private function getStationId()
    {
        return Auth::user()->station_id ?? 1;
    }
}
