<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettlementListcontroller extends Controller
{

    protected array $pageHeader;

    public function __construct()
    {
        $this->pageHeader = [
            'title' => 'Settlement List',
            'icon'  => 'mdi mdi-file-document'
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
                    'settlement ID',
                    'Settlement Date',
                    'Pump Operator',
                    'location',
                    'Shift',
                    'Total Amount',
                    'Status',
                    'Action'
                ],
                'Actions' =>
                ['view','delete']
            ]
        ];
        return view('admin.petro.settlement-list.index', compact('dataTables'));
    }

    // Add this method to return data as JSON
    public function getData()
    {
        return response()->json($this->getDummyData());
    }

    private function getDummyData()
    {
        return [
            [
                'id' => 1,
                'status' => 'Completed',
                'settlement_date' => '31/01/2025',
                'settlement_id' => 'ST135',
                'shift_id' => '1',
                'pump_operator_name' => 'URA_UPG',
                'pumps' => '5 R.M Litres, Lande Pump, 2.14',
                'location' => 'puttalam',
                'shift' => 'Day Shift',
                'note' => '-',
                'total_amount' => '850,759.67',
                'added_user' => 'hadjl502'
            ],
            [
                'id' => 2,
                'status' => 'Pending',
                'settlement_date' => '30/01/2025',
                'settlement_id' => 'ST134',
                'shift_id' => '2',
                'pump_operator_name' => 'JOHN_OPER',
                'pumps' => '3 R.M Litres, BP Pump, 1.85',
                'location' => 'puttalam',
                'shift' => 'Night Shift',
                'note' => 'Variance noted',
                'total_amount' => '725,450.35',
                'added_user' => 'admin01'
            ],
            [
                'id' => 3,
                'status' => 'Completed',
                'settlement_date' => '29/01/2025',
                'settlement_id' => 'ST133',
                'shift_id' => '1',
                'pump_operator_name' => 'SARA_OPT',
                'pumps' => '4 R.M Litres, Shell Pump, 2.05',
                'location' => 'colombo',
                'shift' => 'Day Shift',
                'note' => '-',
                'total_amount' => '920,125.80',
                'added_user' => 'hadjl502'
            ],
            [
                'id' => 4,
                'status' => 'Completed',
                'settlement_date' => '28/01/2025',
                'settlement_id' => 'ST132',
                'shift_id' => '2',
                'pump_operator_name' => 'MIKE_OPR',
                'pumps' => '6 R.M Litres, Mobil Pump, 2.35',
                'location' => 'colombo',
                'shift' => 'Night Shift',
                'note' => '-',
                'total_amount' => '1,050,680.45',
                'added_user' => 'operator02'
            ],
            [
                'id' => 5,
                'status' => 'Completed',
                'settlement_date' => '27/01/2025',
                'settlement_id' => 'ST131',
                'shift_id' => '1',
                'pump_operator_name' => 'ROSE_OPS',
                'pumps' => '5 R.M Litres, Total Pump, 2.15',
                'location' => 'kandy',
                'shift' => 'Day Shift',
                'note' => 'Reconciled',
                'total_amount' => '875,300.20',
                'added_user' => 'hadjl502'
            ],
            [
                'id' => 6,
                'status' => 'Pending',
                'settlement_date' => '26/01/2025',
                'settlement_id' => 'ST130',
                'shift_id' => '2',
                'pump_operator_name' => 'ALEX_OPU',
                'pumps' => '3 R.M Litres, Chevron Pump, 1.95',
                'location' => 'kandy',
                'shift' => 'Night Shift',
                'note' => 'Under review',
                'total_amount' => '680,450.75',
                'added_user' => 'admin01'
            ]
        ];
    }
}