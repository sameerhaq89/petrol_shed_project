<?php

namespace App\Repositories\Interfaces;

interface CashDropRepositoryInterface
{
    public function getByShift(int $shiftId);
    public function create(array $data);
    public function find(int $id);
    public function markAsVerified(int $id);
}