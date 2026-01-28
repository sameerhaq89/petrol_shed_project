<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\StationRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    protected $userRepository;
    protected $stationRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        StationRepositoryInterface $stationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->stationRepository = $stationRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return view('super-admin.pages.users.list', compact('users'));
    }

    public function create()
    {
        $stations = $this->stationRepository->getAllStations();
        $roles = Role::all();
        return view('super-admin.pages.users.create', compact('stations', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'stations' => 'nullable|array',
            'stations.*' => 'exists:stations,id',
        ]);

        DB::beginTransaction();
        try {
            // 1. Determine "Active" Station (First one selected, or null if none)
            $activeStationId = null;
            if (!empty($validated['stations'])) {
                $activeStationId = $validated['stations'][0];
            }

            // 2. Prepare data for Repository
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password'],
                'role_id' => $validated['role_id'],
                'station_id' => $activeStationId, // Set the default active station
            ];

            // 3. Create User
            $user = $this->userRepository->create($userData);

            // 4. Attach Stations (Multi-Station Support)
            if (!empty($validated['stations'])) {
                $user->stations()->sync($validated['stations']);
            }

            DB::commit();

            return redirect()->route('super-admin.users.list')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        $stations = $this->stationRepository->getAllStations();
        $roles = Role::all();
        return view('super-admin.pages.users.edit', compact('user', 'stations', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'stations' => 'nullable|array',
            'stations.*' => 'exists:stations,id',
        ]);

        DB::beginTransaction();
        try {
            $user = $this->userRepository->find($id);

            // 1. Determine "Active" Station Logic
            $currentActiveStationId = $user->station_id;
            $newStationIds = $validated['stations'] ?? [];
            $newActiveStationId = null;

            if (!empty($newStationIds)) {
                if (in_array($currentActiveStationId, $newStationIds)) {
                    // Keep current if it's in the new list
                    $newActiveStationId = $currentActiveStationId;
                } else {
                    // Otherwise default to the first one
                    $newActiveStationId = $newStationIds[0];
                }
            }

            // 2. Prepare data for Repository
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role_id' => $validated['role_id'],
                'station_id' => $newActiveStationId,
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            // 3. Update User
            $this->userRepository->update($id, $userData);

            // 4. Sync Stations
            $user->stations()->sync($newStationIds);

            DB::commit();

            return redirect()->route('super-admin.users.list')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $user = $this->userRepository->find($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    public function admins()
    {
        // Admins and Managers
        $roles = [User::ROLE_ADMIN, User::ROLE_MANAGER];
        $users = $this->userRepository->getAll(null, $roles);
        return view('super-admin.pages.users.list', compact('users'));
    }

    public function staff()
    {
        // Cashiers and Pumpers
        $roles = [User::ROLE_CASHIER, User::ROLE_PUMPER];
        $users = $this->userRepository->getAll(null, $roles);
        return view('super-admin.pages.users.list', compact('users'));
    }
}
