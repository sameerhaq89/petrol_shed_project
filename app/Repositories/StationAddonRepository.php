<?php

namespace App\Repositories;

use App\Interfaces\StationAddonRepositoryInterface;
use App\Models\StationAddon;
use App\Models\Addon;
use Carbon\Carbon;

class StationAddonRepository implements StationAddonRepositoryInterface
{
    public function getStationAddons($stationId)
    {
        return StationAddon::where('station_id', $stationId)
            ->with('addon')
            ->get();
    }

    public function getEnabledAddons($stationId)
    {
        return StationAddon::where('station_id', $stationId)
            ->where('is_enabled', true)
            ->with('addon')
            ->get();
    }

    public function enableAddon($stationId, $addonId)
    {
        return StationAddon::updateOrCreate(
            [
                'station_id' => $stationId,
                'addon_id' => $addonId,
            ],
            [
                'is_enabled' => true,
                'enabled_at' => Carbon::now(),
            ]
        );
    }

    public function disableAddon($stationId, $addonId)
    {
        $stationAddon = StationAddon::where('station_id', $stationId)
            ->where('addon_id', $addonId)
            ->first();

        if ($stationAddon) {
            $stationAddon->is_enabled = false;
            $stationAddon->save();
        }

        return $stationAddon;
    }

    public function syncStationAddons($stationId, array $addonIds)
    {
        // Disable all current addons
        StationAddon::where('station_id', $stationId)->update(['is_enabled' => false]);

        // Enable selected addons
        foreach ($addonIds as $addonId) {
            $this->enableAddon($stationId, $addonId);
        }

        return $this->getEnabledAddons($stationId);
    }

    public function isAddonEnabled($stationId, $addonSlug)
    {
        $addon = Addon::where('slug', $addonSlug)->first();
        
        if (!$addon) {
            return false;
        }

        $stationAddon = StationAddon::where('station_id', $stationId)
            ->where('addon_id', $addon->id)
            ->where('is_enabled', true)
            ->first();

        return $stationAddon !== null;
    }
}
