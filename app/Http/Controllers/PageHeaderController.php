<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageHeaderController extends Controller
{
    protected array $pageHeader;

    public function __construct()
    {
        $this->pageHeader = [
            'title' => 'Dip management',
            'icon'  => 'mdi mdi-water',
            'showButton' => true,
            'buttonText' => 'Export',
            'buttonId' => 'exportDipBtn',
        ];
    }
}
