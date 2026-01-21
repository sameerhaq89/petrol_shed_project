<?php

namespace App\Services;

use App\Interfaces\DipReadingRepositoryInterface;
use App\Models\Tank;
use Illuminate\Support\Facades\DB;

class DipReadingService
{
    protected $repository;

    public function __construct(DipReadingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getReadingsForTable()
    {
        $readings = $this->repository->getAll();

        return $readings->map(function ($reading) {
            return [
                'id' => $reading->id,
                'tank_id' => $reading->tank_id,
                'raw_volume' => $reading->volume_liters,
                'raw_level' => $reading->dip_level_cm,
                'raw_temp' => $reading->temperature,
                'date' => $reading->reading_date->format('Y-m-d'),
                'tank_name' => $reading->tank->tank_name ?? 'Unknown',
                'fuel_type' => $reading->tank->fuelType->name ?? 'N/A',
                'dip_level' => number_format($reading->dip_level_cm, 2),
                'volume' => number_format($reading->volume_liters, 2),
                'temperature' => $reading->temperature ?? '-',
                'recorded_by' => $reading->recorder->name ?? 'User #'.$reading->recorded_by,
                'notes' => $reading->notes,
            ];
        });
    }

    public function createDipReading(array $data)
    {
        return DB::transaction(function () use ($data) {

            $dip = $this->repository->create($data);
            $tank = Tank::find($data['tank_id']);
            if ($tank) {
                $tank->current_stock = $data['volume_liters'];
                $tank->save();
            }

            return $dip;
        });
    }

    public function updateDipReading(int $id, array $data)
    {

        $updatedDip = $this->repository->update($id, $data);
        $latestReading = $this->repository->getLatestForTank($updatedDip->tank_id);
        if ($latestReading && $latestReading->id == $updatedDip->id) {
            $tank = Tank::findOrFail($updatedDip->tank_id);
            $tank->current_stock = $updatedDip->volume_liters;
            $tank->save();
        }

        return $updatedDip;
    }

    public function deleteDipReading($id)
    {

        $readingToDelete = $this->repository->find($id);
        $tankId = $readingToDelete->tank_id;
        $latestReading = $this->repository->getLatestForTank($tankId);

        if ($latestReading && $latestReading->id == $readingToDelete->id) {

            $previousReading = $this->repository->getSecondLatestForTank($tankId, $id);
            $tank = Tank::findOrFail($tankId);

            if ($previousReading) {
                $tank->current_stock = $previousReading->volume_liters;
            } else {
                $tank->current_stock = 0;
            }

            $tank->save();
        }

        return $this->repository->delete($id);
    }
}
