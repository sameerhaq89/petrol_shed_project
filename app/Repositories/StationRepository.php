<?php

namespace App\Repositories;

use App\Interfaces\StationRepositoryInterface;
use App\Models\Station;

class StationRepository implements StationRepositoryInterface
{
    public function getAllStations()
    {
        return Station::all();
    }

    public function getStationById($stationId)
    {
        return Station::findOrFail($stationId);
    }

    public function createStation(array $stationDetails)
    {
        return Station::create($stationDetails);
    }

    public function updateStation($stationId, array $newDetails)
    {
        $station = Station::findOrFail($stationId);
        $station->update($newDetails);
        return $station;
    }

    public function deleteStation($stationId)
    {
        Station::destroy($stationId);
    }
}
