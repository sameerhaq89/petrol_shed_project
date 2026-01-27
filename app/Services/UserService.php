<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Models\Station;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers()
    {
        $user = Auth::user();
        $stationId = $user->station_id ?? null;

        return $this->repository->getAll($stationId);
    }

    public function getUserById(int $id)
    {
        return $this->repository->find($id);
    }

    public function createUser(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateUser(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteUser(int $id)
    {

        $user = $this->repository->find($id);

        if ($user->id === Auth::id()) {
            throw new Exception('You cannot delete your own account.');
        }

        $managedStation = Station::where('admin_user_id', $user->id)->first();
        if ($managedStation) {
            throw new Exception("Cannot delete user. They are the Admin for station: {$managedStation->name}. Please reassign the station admin first.");
        }

        return $this->repository->delete($id);
    }
}
