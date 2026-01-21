<?php

namespace App\Services;

use App\Interfaces\SaleRepositoryInterface;
use App\Models\Shift;

class SaleService
{
    protected $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function getAllSales()
    {
        return $this->saleRepository->getAllSales();
    }

    public function createSale(array $data)
    {
        // Auto-assign active shift if missing
        if (empty($data['shift_id'])) {
            $shift = Shift::where('station_id', $data['station_id'])
                ->where('status', 'open')
                ->first();

            if (!$shift) {
                throw new \Exception("No active shift found");
            }
            $data['shift_id'] = $shift->id;
        }

        $data['amount'] = $data['quantity'] * $data['rate'];
        $data['final_amount'] = $data['amount']; // Apply discount if needed
        $data['sale_datetime'] = now();
        $data['sale_number'] = 'SALE-' . time();
        $data['created_by'] = auth()->id();

        $sale = $this->saleRepository->createSale($data);

        // Update Shift Totals
        $this->updateShiftTotals($data['shift_id'], $data['final_amount'], $data['payment_mode']);

        // Update Tank Level
        $this->updateTankLevel($data['pump_id'], $data['quantity']);

        return $sale;
    }

    protected function updateTankLevel($pumpId, $quantity)
    {
        $pump = \App\Models\Pump::find($pumpId);
        if ($pump && $pump->tank) {
            $pump->tank->decrement('current_level', $quantity);
        } elseif ($pump && $pump->tank_id) {
            // Fallback if relation is not loaded or issue with relation definition
            \App\Models\Tank::where('id', $pump->tank_id)->decrement('current_level', $quantity);
        }
    }

    protected function updateShiftTotals($shiftId, $amount, $paymentMode)
    {
        $shift = Shift::find($shiftId);
        if ($shift) {
            if ($paymentMode == 'cash') {
                $shift->increment('cash_sales', $amount);
            }
            $shift->increment('total_sales', $amount);
        }
    }
}
