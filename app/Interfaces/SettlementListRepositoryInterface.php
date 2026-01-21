<?php

namespace App\Interfaces;

interface SettlementListRepositoryInterface
{
    public function getCurrentOpenShift();
    public function getClosedShifts();
}