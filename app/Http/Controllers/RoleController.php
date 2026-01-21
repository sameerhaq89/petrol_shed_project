<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRolePermissionsRequest;
use App\Services\RoleService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        $roles = $this->roleService->getManageableRoles();
        
        $pageHeader = [
            'title' => 'Role Management',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('home')],
                ['name' => 'Roles', 'url' => '#']
            ]
        ];

        return view('admin.roles.index', compact('roles', 'pageHeader'));
    }

    public function edit($id): View
    {
        $role = $this->roleService->getRoleById($id);
        $permissions = $this->roleService->getGroupedPermissions();
        
        $pageHeader = [
            'title' => 'Edit Permissions: ' . $role->name,
            'breadcrumbs' => [
                ['name' => 'Roles', 'url' => route('roles.index')],
                ['name' => 'Edit', 'url' => '#']
            ]
        ];

        return view('admin.roles.edit', compact('role', 'permissions', 'pageHeader'));
    }

    public function update(UpdateRolePermissionsRequest $request, $id): RedirectResponse
    {
        try {
            $this->roleService->syncRolePermissions($id, $request->permissions ?? []);
            return redirect()->route('roles.index')->with('success', 'Permissions updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}