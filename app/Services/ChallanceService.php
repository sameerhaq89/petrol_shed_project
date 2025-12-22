<?php

namespace App\Services;

use App\Models\Challans; // Replace 'YourModel' with the actual model name
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class ChallanceService
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }
    public function getData()
    {
        // $this->userRepository->getAll(); // Example usage of the UserRepository
        return Challans::all();
    }
}
