<?php

namespace App\Interfaces;

interface RoleRepositoryInterface
{
    public function getManageableRoles();
    public function find(int $id);
    public function getAllPermissions();
    public function syncPermissions(int $roleId, array $permissionIds);
}