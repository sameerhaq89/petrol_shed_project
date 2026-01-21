<?php

namespace App\Interfaces;

interface DipReadingRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function find(int $id);
    public function getLatestForTank(int $tankId);
    public function getSecondLatestForTank(int $tankId, int $excludeId);
}