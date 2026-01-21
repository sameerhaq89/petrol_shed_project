<?php

namespace App\Interfaces;

interface CashDropRepositoryInterface
{
    public function getByShift(int $shiftId);
    public function create(array $data);
    public function find(int $id);
    public function verify(int $id, int $receiverId);
    public function delete(int $id);
}