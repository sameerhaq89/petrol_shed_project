<?php

namespace App\Services;

use App\Models\Purchase;
use App\Interfaces\TankRepositoryInterface;

class PurchaseService
{
    protected $tankRepo;

    public function __construct(TankRepositoryInterface $tankRepo)
    {
        $this->tankRepo = $tankRepo;
    }

    public function getAllPurchases()
    {
        return Purchase::all();
    }

    public function createPurchase(array $data)
    {
        $data['total_amount'] = $data['quantity'] * $data['unit_price'];
        $data['status'] = 'pending';
        $data['created_by'] = auth()->id();

        return Purchase::create($data);
    }

    public function receivePurchase($id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase || $purchase->status == 'received') {
            throw new \Exception("Invalid purchase");
        }

        // Update Tank Stock via Repository (or TankService if we refactored fully)
        // Keeping Repository use here as it was passed in previously
        $this->tankRepo->updateStock(
            $purchase->tank_id,
            (float) $purchase->quantity,
            'purchase',
            'Purchase #' . $purchase->id
        );

        $purchase->update([
            'status' => 'received',
            'received_at' => now()
        ]);

        return $purchase;
    }

    public function getPurchaseById($id)
    {
        return Purchase::find($id);
    }
}
