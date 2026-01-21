<?php

namespace App\Interfaces;

interface ShiftRepositoryInterface
{
    public function getAll(array $filters = []);
    public function find(int $id);
    public function findActiveShift(int $stationId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function countShiftsForDate($date);
}