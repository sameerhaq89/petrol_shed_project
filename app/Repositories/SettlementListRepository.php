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

        // Filter by the user's active station ID (set by Station Switcher), regardless of role.
        if (Auth::check() && Auth::user()->station_id) {
            $query->where('station_id', Auth::user()->station_id);
        }

        return $query->first();
    }

    public function getClosedShifts()
    {
        $query = Shift::with(['station', 'user'])
            ->where('status', 'closed')
            ->orderBy('id', 'desc');

        // Filter by the user's active station ID (set by Station Switcher), regardless of role.
        if (Auth::check() && Auth::user()->station_id) {
            $query->where('station_id', Auth::user()->station_id);
        }

        return $query->get();
    }
}
