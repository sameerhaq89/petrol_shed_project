<?php

namespace App\Interfaces;

interface PumperRepositoryInterface
{
    // Assignment Management
    public function getActiveShift();
    public function getBusyPumperIds();
    public function getAvailablePumpers(array $busyIds);
    public function getActiveAssignments();
    public function getPumperStats($shiftId);
    public function getAvailablePumps(array $assignedPumpIds);
    
    // Core Actions
    public function createAssignment(array $data);
    public function findAssignment(int $id);
    public function updateAssignment(int $id, array $data);
    
    // Ledger & Cash
    public function createCashDrop(array $data);
    public function getLatestLedgerBalance(int $userId);
    public function createLedgerEntry(array $data);
    public function getLedgerHistory(int $userId);
    
    // Reporting
    public function getSalesForAssignment($assignment);
    public function getCashDropsForAssignment($assignment);
}