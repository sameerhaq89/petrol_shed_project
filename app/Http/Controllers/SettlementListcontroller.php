<?php

namespace App\Http\Controllers;

use App\Services\SettlementListService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettlementListController extends Controller
{
    protected $service;

    public function __construct(SettlementListService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        // 1. Get Data from Service
        $data = $this->service->getSettlementListData();

        // 2. Define Header
        $pageHeader = [
            'title' => 'Settlement List',
            'icon' => 'mdi mdi-file-document',
            'showButton' => true,
            'buttonText' => 'Start New Shift',
            'buttonClass' => 'btn btn-gradient-success btn-lg shadow',
            'buttonId' => 'startNewShiftBtn',
            'buttonUrl' => route('settlement.start'),
            'buttonIcon' => 'mdi mdi-play-circle-outline me-2',
            'form' => [
                'action' => route('settlement.start'),
                'method' => 'POST',
            ],
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => route('home')],
                ['name' => 'Settlements', 'url' => '#']
            ]
        ];

        // 3. Pass Data to View
        return view('admin.petro.settlement-list.index', [
            'currentShift' => $data['currentShift'],
            'settlements'  => $data['settlements'],
            'pageHeader'   => $pageHeader
        ]);
    }
}
