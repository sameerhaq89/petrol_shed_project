<?php

namespace App\Interfaces;

interface VarianceRepositoryInterface
{
    public function findByShift(int $shiftId, string $type = 'cash');
    public function updateOrCreate(int $shiftId, string $type, array $data);
    public function update(int $id, array $data);
}