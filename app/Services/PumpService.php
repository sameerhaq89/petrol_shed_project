<?php

namespace App\Services;

use App\Interfaces\PumpRepositoryInterface;

class PumpService
{
    protected $repository;

    public function __construct(PumpRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /* --------------------------------------------------------------------------
     * CORE CRUD METHODS
     * -------------------------------------------------------------------------- */

    public function getAllPumps()
    {
        return $this->repository->getAll();
    }

    public function getPumpById(int $id)
    {
        return $this->repository->find($id);
    }

    public function createPump(array $data)
    {
        return $this->repository->create($data);
    }

    public function updatePump(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deletePump(int $id)
    {
        return $this->repository->delete($id);
    }

    /* --------------------------------------------------------------------------
     * DATA TRANSFORMATION METHODS (FIX FOR YOUR ERROR)
     * -------------------------------------------------------------------------- */

    /**
     * Format 1: For Tank Dashboard (Cards)
     * Used by: TankController
     */
    public function getPumpsForDashboard()
    {
        $pumps = $this->repository->getAll();

        return $pumps->map(function ($pump) {
            return [
                'id'           => $pump->id,
                'pumpName'     => $pump->pump_name, 
                // Assumes relationship: $pump->tank->fuel_type exists or is an ID
                'pumpType'     => $pump->tank ? $pump->tank->tank_name : 'No Tank', 
                'currentMeter' => number_format($pump->last_meter_reading, 2) . ' L',
                'statusIcon'   => $this->getStatusIcon($pump->status),
                'isActive'     => $pump->status === 'active',
                'linkStatus'   => 'Linked to ' . ($pump->tank ? $pump->tank->tank_name : 'No Tank'),
                'actionButton' => [
                    'type'  => 'primary',
                    'icon'  => 'pencil',
                    'label' => 'Edit Pump'
                ]
            ];
        });
    }

    /**
     * Format 2: For Pump Management Page (Table)
     * Used by: PumpController
     */
    public function getPumpsForManagementTable()
    {
        $pumps = $this->repository->getAll();

        return $pumps->map(function ($pump) {
            
            // Safe check for fuel type
            $productName = 'N/A';
            if ($pump->tank) {
                // If your tank model has a relationship to 'fuel_type', use that name.
                // Otherwise, use the ID or raw column.
                $productName = $pump->tank->fuel_type_id ?? 'Unknown'; 
            }

            return [
                'id'               => $pump->id,
                'date'             => $pump->created_at->format('Y-m-d'),
                'transaction_date' => $pump->updated_at->format('Y-m-d H:i'),
                'pump_no'          => $pump->pump_number,
                'name'             => $pump->pump_name,
                'start_meter'      => number_format($pump->last_meter_reading, 2),
                'close_meter'      => number_format($pump->last_meter_reading, 2), // Logic for close meter needed later
                'product_name'     => $productName,
                'fuel_tanks'       => $pump->tank ? $pump->tank->tank_name : 'Unassigned',
            ];
        });
    }

    /* --------------------------------------------------------------------------
     * HELPERS
     * -------------------------------------------------------------------------- */

    private function getStatusIcon($status)
    {
        return match ($status) {
            'active'      => 'success',     // Green
            'maintenance' => 'maintenance', // Wrench
            'offline'     => 'error',       // Red
            default       => 'warning',
        };
    }
}