<?php

namespace App\Http\Controllers;

use App\Models\station;
use App\Http\Requests\StorestationRequest;
use App\Http\Requests\UpdatestationRequest;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorestationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(station $station)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(station $station)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatestationRequest $request, station $station)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(station $station)
    {
        //
    }
}
