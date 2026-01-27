<?php

namespace App\Interfaces;

interface StationAddonRepositoryInterface
{
    public function getStationAddons($stationId);
    public function getEnabledAddons($stationId);
    public function enableAddon($stationId, $addonId);
    public function disableAddon($stationId, $addonId);
    public function syncStationAddons($stationId, array $addonIds);
    public function isAddonEnabled($stationId, $addonSlug);
}
