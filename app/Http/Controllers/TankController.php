<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TankController extends Controller
{
    public function index()
    {
        // Sample tank data - replace with database queries later
        $tanks = [
            [
                'tankName' => 'Tank 01 - Petrol 95',
                'percentage' => 70,
                'capacity' => '8,000L',
                'lastDip' => '10 mins ago',
                'color' => 'blue',
                'alertStatus' => null
            ],
            [
                'tankName' => 'Tank 02 - 80009',
                'percentage' => 10,
                'capacity' => '8,000L',
                'lastDip' => '10 mins ago',
                'color' => 'orange',
                'alertStatus' => 'low-stock'
            ],
            [
                'tankName' => 'Tank 02 - 8000L',
                'percentage' => 55,
                'capacity' => 'N/A',
                'lastDip' => null,
                'color' => 'green',
                'alertStatus' => 'low-stock'
            ],
            [
                'tankName' => 'Super Petrol',
                'percentage' => 30,
                'capacity' => '3,000L',
                'lastDip' => '10 mins ago',
                'color' => 'red',
                'alertStatus' => null
            ]
        ];

        // Sample pump distribution data
        $pumps = [
            [
                'pumpName' => 'Pump 01',
                'pumpType' => 'Tump 01 (Petrol 95)',
                'linkStatus' => 'Liimed Active',
                'currentMeter' => '128450.20 L',
                'isActive' => true,
                'statusIcon' => null,
                'actionButton' => [
                    'type' => 'default',
                    'label' => 'Update Expenses',
                    'icon' => 'file-document'
                ]
            ],
            [
                'pumpName' => 'Pump 05',
                'pumpType' => 'Tump 01 (Petrol 92)',
                'linkStatus' => 'Linked Active',
                'currentMeter' => '128450.20 L',
                'isActive' => true,
                'statusIcon' => 'error',
                'actionButton' => [
                    'type' => 'primary',
                    'label' => 'Sodatise',
                    'icon' => 'update'
                ]
            ],
            [
                'pumpName' => 'Pump 03',
                'pumpType' => 'Tump 01 (Petrol 92)',
                'linkStatus' => 'Liimed Actier',
                'currentMeter' => '128465.20 L',
                'isActive' => true,
                'statusIcon' => null,
                'actionButton' => [
                    'type' => 'default',
                    'label' => 'Update Price',
                    'icon' => 'cash'
                ]
            ],
            [
                'pumpName' => 'Pump 05',
                'pumpType' => 'Tump 07 (Petrol 92)',
                'linkStatus' => 'Linked Active',
                'currentMeter' => '128765.20 L',
                'isActive' => true,
                'statusIcon' => 'error',
                'actionButton' => [
                    'type' => 'default',
                    'label' => 'Log Maintenance',
                    'icon' => 'wrench'
                ]
            ],
            [
                'pumpName' => 'Pump 06',
                'pumpType' => 'Tump 01 (Petrol 92)',
                'linkStatus' => 'Linked Netter',
                'currentMeter' => '128465.20 L',
                'isActive' => true,
                'statusIcon' => 'maintenance',
                'actionButton' => [
                    'type' => 'primary',
                    'label' => 'Log ste Pie',
                    'icon' => 'chart-line'
                ]
            ]
        ];

        return view('admin.petro.tank-management.index', compact('tanks', 'pumps'));
    }
}
