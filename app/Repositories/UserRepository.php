<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAll($stationId = null, array $roleIds = [])
    {
        $query = User::with(['role', 'station']);

        if ($stationId) {
            $query->where('station_id', $stationId);
        }

        if (!empty($roleIds)) {
            $query->whereIn('role_id', $roleIds);
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role_id' => $data['role_id'],
            'station_id' => $data['role_id'] == 1 ? null : ($data['station_id'] ?? null),
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'role_id' => $data['role_id'],
            'station_id' => $data['role_id'] == 1 ? null : ($data['station_id'] ?? null),
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
        return $user;
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
