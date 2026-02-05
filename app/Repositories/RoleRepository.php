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
        $query = Role::where('id', '!=', 1);

        // If authenticated user is NOT Super Admin, they cannot create/assign Station Admin (ID 2)
        if (auth()->check() && auth()->user()->role_id != 1) {
            $query->where('id', '!=', 2);
        }

        return $query->get();
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
