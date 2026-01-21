<?php

namespace App\Services;

use App\Interfaces\SettlementListRepositoryInterface;

class SettlementListService
{
    protected $repository;

    public function __construct(SettlementListRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSettlementListData()
    {
        return [
            'currentShift' => $this->repository->getCurrentOpenShift(),
            'settlements'  => $this->repository->getClosedShifts()
        ];
    }
}