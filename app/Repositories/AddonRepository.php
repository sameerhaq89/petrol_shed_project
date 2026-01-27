<?php

namespace App\Repositories;

use App\Interfaces\AddonRepositoryInterface;
use App\Models\Addon;

class AddonRepository implements AddonRepositoryInterface
{
    public function getAllAddons()
    {
        return Addon::orderBy('sort_order')->get();
    }

    public function getActiveAddons()
    {
        return Addon::active()->get();
    }

    public function getAddonById($id)
    {
        return Addon::findOrFail($id);
    }

    public function getAddonBySlug($slug)
    {
        return Addon::where('slug', $slug)->firstOrFail();
    }

    public function createAddon(array $data)
    {
        return Addon::create($data);
    }

    public function updateAddon($id, array $data)
    {
        $addon = $this->getAddonById($id);
        $addon->update($data);
        return $addon;
    }

    public function deleteAddon($id)
    {
        $addon = $this->getAddonById($id);
        return $addon->delete();
    }

    public function toggleAddonStatus($id)
    {
        $addon = $this->getAddonById($id);
        $addon->is_active = !$addon->is_active;
        $addon->save();
        return $addon;
    }
}
