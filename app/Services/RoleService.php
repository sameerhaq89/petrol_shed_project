<?php

namespace App\Services;

use App\Interfaces\RoleRepositoryInterface;

class RoleService
{
    protected $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getManageableRoles()
    {
        return $this->repository->getManageableRoles();
    }

    public function getRoleById(int $id)
    {
        return $this->repository->find($id);
    }

    public function getGroupedPermissions()
    {
        $permissions = $this->repository->getAllPermissions();

        return $permissions->groupBy(function ($perm) {
          
            $parts = explode('.', $perm->slug); 
            return ucfirst($parts[0] ?? 'Other');
        });
    }

    public function syncRolePermissions(int $roleId, array $permissions)
    {
     
        if ($roleId == 1) {
            throw new \Exception("Cannot modify Super Admin permissions.");
        }

        return $this->repository->syncPermissions($roleId, $permissions);
    }
}