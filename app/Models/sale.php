<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    // FIX: Allow all columns to be saved
    protected $guarded = [];

    protected $casts = [
        'sale_datetime' => 'datetime',
        'is_voided' => 'boolean',
        'voided_at' => 'datetime',
    ];

    /**
     * Relationship: Sale belongs to a Station.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }

    /**
     * Relationship: Sale MAY belong to a Customer (if credit/loyalty).
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship: Who created the sale.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}