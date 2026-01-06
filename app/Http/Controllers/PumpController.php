<?php

namespace App\Http\Controllers;

use App\Http\Controllers;

use Illuminate\Http\Request;

class PumpController extends Controller
{

    protected array $pageHeader;

    public function __construct()
    {
        $this->pageHeader = [
            'title' => 'Pump Management',
            'icon'  => 'mdi mdi-gas-station'
        ];

        view()->share('pageHeader', $this->pageHeader);
    }

    public function index()
    {
        $pumpRows = [
            ['2026-01-06', '2026-01-06', '1', 'Pump A', '2000', '1000', 'Petrol', 'Tank 1'],
            ['2026-01-06', '2026-01-06', '2', 'Pump B', '3000', '2000', 'Diesel', 'Tank 2'],
        ];

        $testingDetails = [
            ['2026-01-06', 'Station 1', 'S001', 'P03', 'Diesel', 'John', 50, 2000],
            ['2026-01-06', 'Station 2', 'S002', 'P02', 'Petrol', 'Mike', 40, 1500],
        ];

        $meterReadings = [
            ['2026-01-06', 'Station 1', 'S001', 'John', 'P03', 'Diesel', 50, 2000, 2050, 50, 250],
            ['2026-01-06', 'Station 2', 'S002', 'Mike', 'P02', 'Petrol', 40, 1500, 1540, 40, 160],
            ['2026-01-07', 'Station 3', 'S003', 'Anna', 'P01', 'Diesel', 60, 3000, 3060, 60, 300],
            ['2026-01-07', 'Station 4', 'S004', 'Tom', 'P04', 'Petrol', 30, 1200, 1230, 30, 120],
            ['2026-01-08', 'Station 5', 'S005', 'Sara', 'P05', 'Diesel', 45, 2500, 2545, 45, 225],
            ['2026-01-08', 'Station 6', 'S006', 'Leo', 'P06', 'Petrol', 35, 1700, 1735, 35, 140],
        ];


        $dataTables = [
            'pumps' => [
                'title'   => 'Pump',
                'id' => 'pumpWidget',
                'class' => ['active'],
                'columns' => [
                    'Date',
                    'Transaction Date',
                    'Pump No',
                    'Pump Name',
                    'Starting Meter',
                    'Current Meter',
                    'Product Name',
                    'Fuel Tank',
                ],
                'Action' =>
                ['view', 'edit', 'delete'],
                'rows'    => $pumpRows
            ],
            'testingDetails' => [
                'title'   => 'Test',
                'id' => 'testingWidget',
                'class' => ['d-none'],
                'columns' => [
                    'Transaction Date',
                    'Location',
                    'Settlement No',
                    'Pump No',
                    'Product',
                    'Pump Operator',
                    'Testing Liter',
                    'Testing Sale Value'
                ],
                'Action' =>
                ['edit', 'delete'],
                'rows' => $testingDetails
            ],
            'meterReadings' => [
                'title'   => 'Meter Readings',
                'id' => 'meterReadingWidget',
                'class' => ['d-none'],
                'columns' => [
                    'Transaction Date',
                    'Location',
                    'Settlement No',
                    'Pump operator',
                    'Pump No',
                    'Product',
                    'Sold',
                    'Start Meter',
                    'Close Meter',
                    'Testing Qty',
                    'Sale Amount'
                ],
                'Action' =>
                ['view', 'edit', 'delete'],
                'rows'    => $meterReadings
            ]
        ];
        return view('admin.petro.pump-management.index', compact('dataTables'));
    }
}
