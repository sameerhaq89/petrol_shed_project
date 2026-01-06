<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class SettlementController extends Controller
{

    protected array $pageHeader;

    public function __construct()
    {
        $this->pageHeader = [
            'title' => 'Daily Settlement',
            'icon'  => 'mdi mdi-cash-register'
        ];

        view()->share('pageHeader', $this->pageHeader);
    }

    public function index()
    {

        $dataTables = [
            'Entry' => [
                'title'   => 'Entry',
                'id' => 'pumpWidget',
                'class' => ['active'],
                'columns' => [
                    'Code',
                    'Products',
                    'Pump',
                    'Start Meter',
                    'Close Meter',
                    'Price',
                    'Sold Qty',
                    'Total Price',
                    'Action'
                ],
                'Actions' =>
                ['view', 'edit', 'delete']
            ]
        ];
        return view('admin.petro.settlement.index', compact('dataTables'));
    }

    public function entries()
    {
        $entries = [
            [
                'code' => 'A0023L99',
                'products' => 'Lanka Petrol 92',
                'pump' => 'LP1',
                'start_meter' => '912,500.50',
                'close_meter' => '914,672.56',
                'price' => 297,
                'sold_qty' => '2,172.06', // close_meter - start_meter
                'total_price' => '645,164.82', // sold_qty * price
                'discount_type' => 'None',
                'discount_value' => 0,
                'total_qty' => '2,172.06',
                'before_discount' => '645,164.82',
                'after_discount' => '645,164.82'
            ],
            [
                'code' => 'B0012M88',
                'products' => 'Diesel 50',
                'pump' => 'LP2',
                'start_meter' => '500,000.00',
                'close_meter' => '502,350.00',
                'price' => 300,
                'sold_qty' => '2,350.00',
                'total_price' => '705,000.00',
                'discount_type' => 'Seasonal 5%',
                'discount_value' => 5, // percent
                'total_qty' => '2,350.00',
                'before_discount' => '705,000.00',
                'after_discount' => '669,750.00' // 705,000 - 5%
            ],
            [
                'code' => 'C0035D77',
                'products' => 'Lanka Petrol 95',
                'pump' => 'LP3',
                'start_meter' => '120,000.00',
                'close_meter' => '121,500.50',
                'price' => 310,
                'sold_qty' => '1,500.50',
                'total_price' => '465,155.00',
                'discount_type' => 'Loyalty 2%',
                'discount_value' => 2,
                'total_qty' => '1,500.50',
                'before_discount' => '465,155.00',
                'after_discount' => '456,852.90'
            ],
            [
                'code' => 'D0047P66',
                'products' => 'Diesel 60',
                'pump' => 'LP4',
                'start_meter' => '800,000.00',
                'close_meter' => '802,100.00',
                'price' => 305,
                'sold_qty' => '2,100.00',
                'total_price' => '640,500.00',
                'discount_type' => 'Bulk 3%',
                'discount_value' => 3,
                'total_qty' => '2,100.00',
                'before_discount' => '640,500.00',
                'after_discount' => '620,685.00'
            ]
        ];

        return response()->json($entries);
    }
}
