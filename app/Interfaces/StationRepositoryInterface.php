<?php

namespace App\Interfaces;

interface StationRepositoryInterface
{
    public function getAllStations();
    public function getStationById($stationId);
    public function createStation(array $stationDetails);
    public function updateStation($stationId, array $newDetails);
    public function deleteStation($stationId);
}
