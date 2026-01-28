<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Make sure Tank is imported if it's in the same namespace (usually optional but good practice)
use App\Models\Tank;

class FuelType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'unit',
        'density',
        'color_code',
        'is_active',
        'station_id' // Added just in case, though not in request, often needed later
    ];

    // ... other existing relationship methods ...

    /**
     * Define the relationship: A Fuel Type has many Tanks.
     */
    public function tanks()
    {
        return $this->hasMany(Tank::class);
    }

    public function fuelPrices()
    {
        return $this->hasMany(FuelPrice::class);
    }

    public function currentPrice()
    {
        return $this->hasOne(FuelPrice::class)->latestOfMany('effective_from');
    }
}