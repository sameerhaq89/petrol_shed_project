<?php

namespace App\Http\Controllers;

use App\Models\DipManagement;
use App\Http\Requests\StoreDipManagementRequest;
use App\Http\Requests\UpdateDipManagementRequest;

class DipManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected array $pageHeader;

    public function __construct()
    {
        $this->pageHeader = [
            'title' => 'Dip management',
            'icon'  => 'mdi mdi-water',
            'showButton' => true,
            'buttonText' => 'Export',
            'buttonId' => 'exportDipBtn',
            'buttonClass' => 'btn btn-sm btn-outline-secondary',
            'buttonIcon' => 'mdi mdi-export',
        ];

        view()->share('pageHeader', $this->pageHeader);
    }

    public function index()
    {
        return view('admin.petro.dip-management.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDipManagementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DipManagement $dipManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DipManagement $dipManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDipManagementRequest $request, DipManagement $dipManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DipManagement $dipManagement)
    {
        //
    }
}
