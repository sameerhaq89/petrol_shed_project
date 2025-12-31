<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SettlementController extends Controller
{

    public function index()
    {
        return view('admin.petro.settlement.index');
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
                'sold_qty' => '2,172.05',
                'total_price' => '638,584.17',
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
            ]
        ];
        
        return response()->json($entries);
    }
}
