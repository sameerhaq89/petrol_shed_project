<?php

namespace App\Http\Controllers;

use App\Services\DipReadingService;
use App\Services\TankService;
use Illuminate\Http\Request;

class DipReadingController extends Controller
{
    protected $dipService;
    protected $tankService;

    public function __construct(DipReadingService $dipService, TankService $tankService)
    {
        $this->dipService = $dipService;
        $this->tankService = $tankService;
    }

    public function index()
    {
        // 1. Get List of Readings
        $dip_readings = $this->dipService->getReadingsForTable();

        // 2. GET TANKS (Required for the Dropdown)
        $tanks = $this->tankService->getAllTanks([]);

        $pageHeader = [
            'title' => 'Dip Management',
            'icon' => 'mdi mdi-water',
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('home')],
                ['name' => 'Dip Readings', 'url' => '#']
            ]
        ];

        // 3. DEBUG CHECK (Optional): Uncomment the line below to test if data exists
        // dd($tanks);

        // 4. PASS '$tanks' TO THE VIEW
        return view('admin.petro.dip-management.index', compact('dip_readings', 'tanks', 'pageHeader'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tank_id'       => [
                'required',
                \Illuminate\Validation\Rule::exists('tanks', 'id')->where(function ($query) {
                    $query->where('station_id', \Illuminate\Support\Facades\Auth::user()->station_id);
                }),
            ],
            'reading_date'  => 'required|date',
            'dip_level_cm'  => 'required|numeric',
            'volume_liters' => 'required|numeric',
            'temperature'   => 'nullable|numeric',
            'notes'         => 'nullable|string'
        ]);

        $this->dipService->createDipReading($request->all());

        return back()->with('success', 'Dip reading recorded successfully.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'tank_id'       => [
                'required',
                \Illuminate\Validation\Rule::exists('tanks', 'id')->where(function ($query) {
                    $query->where('station_id', \Illuminate\Support\Facades\Auth::user()->station_id);
                }),
            ],
            'reading_date'  => 'required|date',
            'dip_level_cm'  => 'required|numeric',
            'volume_liters' => 'required|numeric',
            'temperature'   => 'nullable|numeric',
            'notes'         => 'nullable|string'
        ]);

        $this->dipService->updateDipReading($id, $request->all());

        return back()->with('success', 'Dip reading updated successfully.');
    }

    public function destroy($id)
    {
        $this->dipService->deleteDipReading($id);
        return back()->with('success', 'Dip reading deleted successfully.');
    }
}
