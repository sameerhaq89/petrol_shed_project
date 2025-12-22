<?php

namespace App\Http\Controllers;

use App\Models\AddPurchases;
use App\Http\Requests\StoreAddPurchasesRequest;
use App\Http\Requests\UpdateAddPurchasesRequest;

class AddPurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.purchases.add-purchases');
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
    public function store(StoreAddPurchasesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AddPurchases $addPurchases)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddPurchases $addPurchases)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddPurchasesRequest $request, AddPurchases $addPurchases)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddPurchases $addPurchases)
    {
        //
    }
}
