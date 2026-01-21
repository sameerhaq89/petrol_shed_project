<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'user_id',
        'shift_number',
        'shift_date',
        'start_time',
        'end_time',
        'opening_cash',
        'closing_cash',
        'expected_cash',
        'cash_variance',
        'cash_sales',
        'card_sales',
        'upi_sales',
        'credit_sales',
        'total_sales',
        'total_fuel_sold',
        'total_transactions',
        'status',
        'opening_notes',
        'closing_notes',
        'closed_by',
        'closed_at'
    ];

    // --- ADD THESE MISSING RELATIONSHIPS ---

    /**
     * Relationship: A shift belongs to a Station.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Relationship: A shift is opened by a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A shift has many Cash Drops.
     */
    public function cashDrops()
    {
        return $this->hasMany(CashDrop::class);
    }

    /**
     * Relationship: A shift has many Sales.
     */
public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    
    /**
     * Relationship: A shift has many Expenses.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}