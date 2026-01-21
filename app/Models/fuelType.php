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
        // ... your existing fillable fields ...
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