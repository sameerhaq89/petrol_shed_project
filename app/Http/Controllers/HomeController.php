<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected array $pageHeader;

    public function __construct()
    {
        $this->middleware('auth');

        $this->pageHeader = [
            'title' => 'Petrol Station Dashboard',
            'icon'  => 'mdi mdi-gas-station',
            'showButton' => false,
            'buttonText' => '',
            'buttonId' => '',
            'buttonClass' => '',
            'buttonIcon' => '',
        ];

        view()->share('pageHeader', $this->pageHeader);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }
}
