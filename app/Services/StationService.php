<?php

namespace App\Services;

use App\Models\Station;

class StationService
{
    public function getAllStations()
    {
        return Station::all();
    }

    public function createStation(array $data)
    {
        return Station::create($data);
    }

    public function getStationById($id)
    {
        return Station::with('admin')->find($id);
    }

    public function updateStation($id, array $data)
    {
        $station = Station::find($id);
        if ($station) {
            $station->update($data);
        }
        return $station;
    }

    public function deleteStation($id)
    {
        $station = Station::find($id);
        if ($station) {
            $station->delete();
            return true;
        }
        return false;
    }
}
