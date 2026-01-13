<?php

namespace App\Repositories;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAllSales()
    {
        return Sale::all();
    }

    public function getSaleById($saleId)
    {
        return Sale::findOrFail($saleId);
    }

    public function createSale(array $saleDetails)
    {
        return Sale::create($saleDetails);
    }

    public function updateSale($saleId, array $newDetails)
    {
        $sale = Sale::findOrFail($saleId);
        $sale->update($newDetails);
        return $sale;
    }

    public function deleteSale($saleId)
    {
        Sale::destroy($saleId);
    }
}
