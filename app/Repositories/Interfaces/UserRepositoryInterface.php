<?php
namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAll() : Collection;
    public function create(array $data) : User;
    public function findByEmail(string $email) : ?User;
    public function findById(int $id) : ?User;
    public function findByPhone(string $phone) : ?User;
    public function update(int $id, array $data) : ?User;
    public function updatePassword(int $id, string $password) : bool;
    public function findByPasswordResetToken(string $token) : ?User;
    public function setPasswordResetToken(int $id, ?string $token) : bool;
}