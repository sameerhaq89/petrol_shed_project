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