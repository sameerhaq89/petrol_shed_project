<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByPhone(string $phone): ?User
    {
        return User::where('phone', $phone)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function update(int $id, array $data): ?User
    {
        $user = $this->findById($id);
        if ($user) {
            $user->update($data);
            return $user->fresh();
        }
        return null;
    }

    public function updatePassword(int $id, string $password): bool
    {
        return User::where('id', $id)->update(['password' => $password]);
    }

    public function findByPasswordResetToken(string $token): ?User
    {
        return User::where('password_reset_token', $token)->first();
    }

    public function setPasswordResetToken(int $id, ?string $token): bool
    {
        return (bool) User::where('id', $id)->update(['password_reset_token' => $token]);
    }
}