<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tank extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Relationship: A Tank belongs to a specific Fuel Type.
     * This fixes the "Call to undefined relationship [fuelType]" error.
     */
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id');
    }

    /**
     * Relationship: A Tank belongs to a Station.
     */
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }

    /**
     * Relationship: A Tank can have many Pumps.
     */
    public function pumps()
    {
        return $this->hasMany(Pump::class);
    }
}