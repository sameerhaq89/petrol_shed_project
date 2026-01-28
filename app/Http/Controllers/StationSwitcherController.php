<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Station;

class StationSwitcherController extends Controller
{
    public function switch(Request $request)
    {
        $validated = $request->validate([
            'station_id' => 'required|exists:stations,id',
        ]);

        $user = Auth::user();
        $targetStationId = $validated['station_id'];

        // Verify the user belongs to this station
        if (!$user->stations->contains($targetStationId)) {
            return back()->with('error', 'You do not have access to this station.');
        }

        // Update the active station context
        $user->station_id = $targetStationId;
        $user->save();

        return back()->with('success', 'Switched to station successfully.');
    }
}
