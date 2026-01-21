<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use HasFactory;

    protected $fillable = [
        'pump_number',
        'pump_name',
        'station_id',
        'tank_id',       // Ensure this exists if linking to tank
        'fuel_type_id',  // Ensure this exists if linking directly to fuel
        'current_reading',
        'status',
        'description'
    ];

    /**
     * Relationship: A Pump belongs to a Station.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Relationship: A Pump belongs to a Tank.
     */
   public function tank()
    {
        return $this->belongsTo(Tank::class, 'tank_id');
    }

    // Optional: Helper to get fuel type easily
    public function fuelType()
    {
        return $this->hasOneThrough(FuelType::class, Tank::class, 'id', 'id', 'tank_id', 'fuel_type_id');
    }
}