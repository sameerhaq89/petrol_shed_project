<?php

namespace App\Http\Controllers;

use App\Models\AddExpenses;
use App\Http\Requests\StoreAddExpensesRequest;
use App\Http\Requests\UpdateAddExpensesRequest;

class AddExpensesController extends Controller
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
        return view('admin.expenses.add-expenses');
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
    public function store(StoreAddExpensesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AddExpenses $addExpenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddExpenses $addExpenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddExpensesRequest $request, AddExpenses $addExpenses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddExpenses $addExpenses)
    {
        //
    }
}
