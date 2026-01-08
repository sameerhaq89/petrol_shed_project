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
        $pumps = [
            [
                'date' => '2026-01-07',
                'transaction_date' => '2026-01-07',
                'pump_no' => 'LP1',
                'name' => 'LP1',
                'start_meter' => '912,500.50',
                'close_meter' => '914,672.56',
                'product_name' => 'Lanka Petrol 92',
                'fuel_tanks' => 'Tank A'
            ],
            [
                'date' => '2026-01-07',
                'transaction_date' => '2026-01-07',
                'pump_no' => 'LP2',
                'name' => 'LP2',
                'start_meter' => '500,000.00',
                'close_meter' => '502,350.00',
                'product_name' => 'Diesel 50',
                'fuel_tanks' => 'Tank B'
            ],
            [
                'date' => '2026-01-07',
                'transaction_date' => '2026-01-07',
                'pump_no' => 'LP3',
                'name' => 'LP3',
                'start_meter' => '120,000.00',
                'close_meter' => '121,500.50',
                'product_name' => 'Lanka Petrol 95',
                'fuel_tanks' => 'Tank C'
            ],
            [
                'date' => '2026-01-07',
                'transaction_date' => '2026-01-07',
                'pump_no' => 'LP4',
                'name' => 'LP4',
                'start_meter' => '800,000.00',
                'close_meter' => '802,100.00',
                'product_name' => 'Diesel 60',
                'fuel_tanks' => 'Tank D'
            ]
        ];

        $testing_details = [
            [
                'transaction_date' => '2026-01-07',
                'location' => 'Colombo Station 1',
                'settlement_no' => 'S001',
                'pump_no' => 'LP1',
                'product' => 'Lanka Petrol 92',
                'operator' => 'John Doe',
                'testing_ltr' => '500.50',
                'testing_sale_value' => '148,648.50'
            ],
            [
                'transaction_date' => '2026-01-07',
                'location' => 'Colombo Station 2',
                'settlement_no' => 'S002',
                'pump_no' => 'LP2',
                'product' => 'Diesel 50',
                'operator' => 'Jane Smith',
                'testing_ltr' => '600.00',
                'testing_sale_value' => '180,000.00'
            ],
            [
                'transaction_date' => '2026-01-07',
                'location' => 'Colombo Station 3',
                'settlement_no' => 'S003',
                'pump_no' => 'LP3',
                'product' => 'Lanka Petrol 95',
                'operator' => 'Alex Brown',
                'testing_ltr' => '450.50',
                'testing_sale_value' => '139,397.50'
            ],
            [
                'transaction_date' => '2026-01-07',
                'location' => 'Colombo Station 4',
                'settlement_no' => 'S004',
                'pump_no' => 'LP4',
                'product' => 'Diesel 60',
                'operator' => 'Maria Green',
                'testing_ltr' => '550.00',
                'testing_sale_value' => '165,500.00'
            ]
        ];

        $meterReadings = [
            [
                'transaction_date' => '2026-01-07 08:30',
                'location' => 'Colombo Station 1',
                'settlement_no' => 'S001',
                'pump_no' => 'LP1',
                'product' => 'Lanka Petrol 92',
                'operator' => 'John Doe',
                'sold_ltr' => '500.50',
                'start_meter' => '912,500.50',
                'close_meter' => '914,672.56',
                'testing_qty' => '2,172.06',
                'sale_amount' => '645,164.82'
            ],
            [
                'transaction_date' => '2026-01-07 09:15',
                'location' => 'Colombo Station 2',
                'settlement_no' => 'S002',
                'pump_no' => 'LP2',
                'product' => 'Diesel 50',
                'operator' => 'Jane Smith',
                'sold_ltr' => '600.00',
                'start_meter' => '500,000.00',
                'close_meter' => '502,350.00',
                'testing_qty' => '2,350.00',
                'sale_amount' => '705,000.00'
            ],
            [
                'transaction_date' => '2026-01-07 10:45',
                'location' => 'Colombo Station 3',
                'settlement_no' => 'S003',
                'pump_no' => 'LP3',
                'product' => 'Lanka Petrol 95',
                'operator' => 'Alex Brown',
                'sold_ltr' => '450.50',
                'start_meter' => '120,000.00',
                'close_meter' => '121,500.50',
                'testing_qty' => '1,500.50',
                'sale_amount' => '465,155.00'
            ],
            [
                'transaction_date' => '2026-01-07 11:30',
                'location' => 'Colombo Station 4',
                'settlement_no' => 'S004',
                'pump_no' => 'LP4',
                'product' => 'Diesel 60',
                'operator' => 'Maria Green',
                'sold_ltr' => '550.00',
                'start_meter' => '800,000.00',
                'close_meter' => '802,100.00',
                'testing_qty' => '2,100.00',
                'sale_amount' => '640,500.00'
            ]
        ];
        return view('admin.petro.pump-management.index', compact('pumps', 'testing_details', 'meterReadings'));
    }
}
