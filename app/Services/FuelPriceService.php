<?php

namespace App\Services;

use App\Interfaces\FuelPriceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FuelPriceService
{
    protected $repository;

    public function __construct(FuelPriceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getDashboardData()
    {
        return [
            'current' => $this->repository->getAllActivePrices(),
            'history' => $this->repository->getHistory()
        ];
    }

  
    public function createPrice(array $data)
    {
        return DB::transaction(function () use ($data) {
            $stationId = Auth::user()->station_id ?? 1; 
            $fuelTypeId = $data['fuel_type_id'];
            $newEffectiveDate = $data['effective_from'];

    
            $margin = $data['selling_price'] - $data['purchase_price'];
            $marginPercentage = $data['purchase_price'] > 0 
                ? ($margin / $data['purchase_price']) * 100 
                : 0;

    
            $previousPrice = $this->repository->getActivePrice($fuelTypeId, $stationId);

  
            if ($previousPrice) {
                
                $this->repository->update($previousPrice->id, [
                    'effective_to' => $newEffectiveDate
                ]);
            }

            return $this->repository->create([
                'fuel_type_id'      => $fuelTypeId,
                'station_id'        => $stationId,
                'purchase_price'    => $data['purchase_price'],
                'selling_price'     => $data['selling_price'],
                'margin'            => $margin,
                'margin_percentage' => $marginPercentage,
                'effective_from'    => $newEffectiveDate,
                'effective_to'      => null, 
                'changed_by'        => Auth::id(),
                'change_reason'     => 'Manual Update via Admin Panel'
            ]);
        });
    }

    public function deletePrice($id)
    {
        return $this->repository->delete($id);
    }
}