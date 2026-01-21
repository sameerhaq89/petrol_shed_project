<?php

namespace App\Services;

use App\Interfaces\CashDropRepositoryInterface;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;
use Exception;

class CashDropService
{
    protected $cashDropRepo;

    public function __construct(CashDropRepositoryInterface $cashDropRepo)
    {
        $this->cashDropRepo = $cashDropRepo;
    }

    /**
     * Handle the logic of finding the active shift and saving the drop.
     */
    public function createDrop(array $data)
    {
        // 1. Find the Active Shift (Business Logic)
        $activeShift = Shift::where('status', 'open')->latest()->first();

        if (!$activeShift) {
            throw new Exception("No active shift found. Please open a shift first.");
        }

        // 2. Prepare Data for Repository
        $dropData = [
            'shift_id' => $activeShift->id,
            // 'station_id' => $activeShift->station_id ?? 1, // field does not exist in migration
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'notes' => $data['notes'] ?? null,
            'dropped_at' => now(),
            'status' => 'pending',
        ];

        // 3. Call Repository
        return $this->cashDropRepo->create($dropData);
    }

    public function verifyDrop($id)
    {
        // Pass the current logged-in user as the 'receiver'
        return $this->cashDropRepo->verify($id, Auth::id());
    }

    public function deleteDrop($id)
    {
        return $this->cashDropRepo->delete($id);
    }
}