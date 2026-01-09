<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PumperController extends Controller
{
    protected array $pageHeader;

    public function __construct()
    {
        $this->pageHeader = [
            'title' => 'Pumper Management',
            'icon'  => 'mdi mdi-account-hard-hat'
        ];

        view()->share('pageHeader', $this->pageHeader);
    }
    public function index()
    {
        return view('admin.petro.pumper-management.index');
    }

     public function getData()
    {
        return response()->json($this->getDummyData());
    }
    private function getDummyData()
    {
        return [
            [
                'id' => 1,
                'action' => 'Actions',
                'current_balance' => '8.0',
                'pump_operator' => 'Vioch',
                'location' => 'S.I.M.I. Infric Lanka "Titro"',
                'sold_fuel_qty_lb' => '12,218.52',
                'sale_amount_fuel' => '5,140,545.55',
                'commission_type' => 'Fixed',
                'commission_rate' => '0',
                'commission_amount' => '0',
                'excess_amount' => '0',
                'short_amount' => '0'
            ],
            [
                'id' => 2,
                'action' => 'Actions',
                'current_balance' => '15.5',
                'pump_operator' => 'Rohan',
                'location' => 'Colombo Central Station',
                'sold_fuel_qty_lb' => '9,850.75',
                'sale_amount_fuel' => '4,120,000.00',
                'commission_type' => 'Percentage',
                'commission_rate' => '2.5',
                'commission_amount' => '103,000.00',
                'excess_amount' => '250.00',
                'short_amount' => '0'
            ],
            [
                'id' => 3,
                'action' => 'Actions',
                'current_balance' => '0.0',
                'pump_operator' => 'Saman',
                'location' => 'Kandy Main Depot',
                'sold_fuel_qty_lb' => '7,420.30',
                'sale_amount_fuel' => '3,105,450.25',
                'commission_type' => 'Fixed',
                'commission_rate' => '0',
                'commission_amount' => '0',
                'excess_amount' => '0',
                'short_amount' => '150.50'
            ],
            [
                'id' => 4,
                'action' => 'Actions',
                'current_balance' => '22.3',
                'pump_operator' => 'Priya',
                'location' => 'Galle Harbor Pump',
                'sold_fuel_qty_lb' => '14,560.80',
                'sale_amount_fuel' => '6,100,750.90',
                'commission_type' => 'Percentage',
                'commission_rate' => '1.8',
                'commission_amount' => '109,813.52',
                'excess_amount' => '0',
                'short_amount' => '0'
            ],
            [
                'id' => 5,
                'action' => 'Actions',
                'current_balance' => '5.5',
                'pump_operator' => 'Kamal',
                'location' => 'Jaffna North Station',
                'sold_fuel_qty_lb' => '6,780.45',
                'sale_amount_fuel' => '2,840,300.75',
                'commission_type' => 'Fixed',
                'commission_rate' => '0',
                'commission_amount' => '0',
                'excess_amount' => '85.25',
                'short_amount' => '0'
            ],
            [
                'id' => 6,
                'action' => 'Actions',
                'current_balance' => '18.9',
                'pump_operator' => 'Nimal',
                'location' => 'Negombo Coastal Pump',
                'sold_fuel_qty_lb' => '11,230.60',
                'sale_amount_fuel' => '4,705,600.40',
                'commission_type' => 'Percentage',
                'commission_rate' => '3.0',
                'commission_amount' => '141,168.01',
                'excess_amount' => '0',
                'short_amount' => '45.75'
            ],
            [
                'id' => 7,
                'action' => 'Actions',
                'current_balance' => '12.1',
                'pump_operator' => 'Vioch',
                'location' => 'S.I.M.I. Infric Lanka "Titro"',
                'sold_fuel_qty_lb' => '10,550.25',
                'sale_amount_fuel' => '4,420,800.30',
                'commission_type' => 'Fixed',
                'commission_rate' => '0',
                'commission_amount' => '0',
                'excess_amount' => '0',
                'short_amount' => '0'
            ],
            [
                'id' => 8,
                'action' => 'Actions',
                'current_balance' => '3.2',
                'pump_operator' => 'Anil',
                'location' => 'Matara Southern Depot',
                'sold_fuel_qty_lb' => '5,670.90',
                'sale_amount_fuel' => '2,375,950.20',
                'commission_type' => 'Percentage',
                'commission_rate' => '2.0',
                'commission_amount' => '47,519.00',
                'excess_amount' => '120.50',
                'short_amount' => '0'
            ],
            [
                'id' => 9,
                'action' => 'Actions',
                'current_balance' => '25.0',
                'pump_operator' => 'Rohan',
                'location' => 'Colombo Central Station',
                'sold_fuel_qty_lb' => '16,320.15',
                'sale_amount_fuel' => '6,835,450.85',
                'commission_type' => 'Percentage',
                'commission_rate' => '2.5',
                'commission_amount' => '170,886.27',
                'excess_amount' => '0',
                'short_amount' => '0'
            ],
            [
                'id' => 10,
                'action' => 'Actions',
                'current_balance' => '7.8',
                'pump_operator' => 'Saman',
                'location' => 'Kandy Main Depot',
                'sold_fuel_qty_lb' => '8,910.35',
                'sale_amount_fuel' => '3,732,150.60',
                'commission_type' => 'Fixed',
                'commission_rate' => '0',
                'commission_amount' => '0',
                'excess_amount' => '0',
                'short_amount' => '95.25'
            ]
        ];
    }
}
