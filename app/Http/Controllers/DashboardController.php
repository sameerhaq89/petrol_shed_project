<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
         // Ensure only authorized users can see dashboard
        $this->middleware('auth');
    }

    public function index(): View
    {
        $data = $this->dashboardService->getDashboardData();

        $pageHeader = [
            'title' => 'Petrol Station Dashboard',
            'icon'  => 'mdi mdi-home menu-icon',
            'breadcrumbs' => [
                ['name' => 'Home', 'url' => route('/')],
                // Add more breadcrumbs if needed
            ]
        ];

        // Merge page header into data array
        $data['pageHeader'] = $pageHeader;

        return view('admin.dashboard.index', $data);
    }
}
