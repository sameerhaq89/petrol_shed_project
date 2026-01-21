<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use App\Models\Permission;

class RoleRepository implements RoleRepositoryInterface
{
    public function getManageableRoles()
    {
        // Exclude Super Admin (ID 1) from list so it cannot be edited
        return Role::where('id', '!=', 1)->get();
    }

    public function find(int $id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function syncPermissions(int $roleId, array $permissionIds)
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->sync($permissionIds);
        return $role;
    }
}