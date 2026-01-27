<?php

namespace App\Interfaces;

interface AddonRepositoryInterface
{
    public function getAllAddons();
    public function getActiveAddons();
    public function getAddonById($id);
    public function getAddonBySlug($slug);
    public function createAddon(array $data);
    public function updateAddon($id, array $data);
    public function deleteAddon($id);
    public function toggleAddonStatus($id);
}
