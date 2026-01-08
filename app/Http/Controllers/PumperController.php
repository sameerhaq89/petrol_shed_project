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
}
