<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Station;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $userService;

    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;

        $this->middleware('can:users.view')->only(['index', 'show']);
        $this->middleware('can:users.create')->only(['create', 'store']);
        $this->middleware('can:users.update')->only(['edit', 'update']);
        $this->middleware('can:users.delete')->only(['destroy']);
    }

    public function index(): View
    {
        $users = $this->userService->getAllUsers();

        $pageHeader = [
            'title' => 'User Management',
            'icon' => 'mdi mdi-account-multiple',
            'showButton' => true,
            'buttonText'  => 'Add New User',
            'buttonIcon'  => 'mdi mdi-plus',
            'buttonClass' => 'btn btn-gradient-primary btn-fw',
            'link' => [
                'url' => route('users.create'),
                'can' => 'create-user',
            ],
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'url'   => route('home'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Users',
                    'url'   => null, // active item
                ],
            ],
        ];

        return view('admin.users.index', compact('users', 'pageHeader'));
    }

    public function create(): View
    {
        $pageHeader = [
            'title' => 'Create New User',
            'icon' => 'mdi mdi-account-plus',
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'url'   => route('home'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Users',
                    'url'   => route('users.index'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Create',
                    'url'   => null, // active item
                ],
            ],
        ];
        $roles = $this->roleService->getManageableRoles();
        $stations = Station::all();

        return view('admin.users.create', compact('roles', 'stations', 'pageHeader'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $this->userService->createUser($request->validated());

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function edit($id): View
    {
        $pageHeader = [
            'title' => 'Edit User',
            'icon' => 'mdi mdi-account-plus',
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'url'   => route('/'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Users',
                    'url'   => route('users.index'),
                    'class' => 'text-gradient-primary text-decoration-none',
                ],
                [
                    'label' => 'Edit',
                    'url'   => null, // active item
                ],
            ],
        ];
        $user = $this->userService->getUserById($id);
        $roles = $this->roleService->getManageableRoles();
        $stations = Station::all();

        return view('admin.users.edit', compact('user', 'roles', 'stations', 'pageHeader'));
    }

    public function update(UpdateUserRequest $request, $id): RedirectResponse
    {
        try {
            $this->userService->updateUser($id, $request->validated());

            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $this->userService->deleteUser($id);

            return back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
