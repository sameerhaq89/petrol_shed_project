<?php

namespace App\Repositories;

use App\Interfaces\SettlementListRepositoryInterface;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class SettlementListRepository implements SettlementListRepositoryInterface
{
    public function getCurrentOpenShift()
    {
        $query = Shift::where('status', 'open')
            ->with(['station', 'sales', 'cashDrops']);

        // Filter by station if not Super Admin
        if (Auth::check() && Auth::user()->role_id !== 1) {
            $query->where('station_id', Auth::user()->station_id);
        }

        return $query->first();
    }

    public function getClosedShifts()
    {
        $query = Shift::with(['station', 'user'])
            ->where('status', 'closed')
            ->orderBy('id', 'desc');

        // Filter by station if not Super Admin
        if (Auth::check() && Auth::user()->role_id !== 1) {
            $query->where('station_id', Auth::user()->station_id);
        }

        return $query->get();
    }
}