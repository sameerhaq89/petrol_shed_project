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
            'icon' => 'mdi mdi-account-key',
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'url'   => route('home'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Roles',
                    'url'   => null, // active item
                ],
            ],
        ];

        return view('admin.roles.index', compact('roles', 'pageHeader'));
    }

    public function edit($id): View
    {
        $role = $this->roleService->getRoleById($id);
        $permissions = $this->roleService->getGroupedPermissions();

        $pageHeader = [
            'title' => 'Manage Permissions for: ' . $role->name,
            'icon' => 'mdi mdi-account-key',
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
