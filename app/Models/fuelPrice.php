<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelPrice extends Model
{
    use HasFactory;

    // Defines which fields can be mass-assigned
    protected $fillable = [
        'fuel_type_id',
        'station_id',
        'purchase_price',
        'selling_price',
        'margin',
        'margin_percentage',
        'effective_from',
        'effective_to',
        'changed_by',
        'change_reason'
    ];

    // Cast dates automatically so Carbon works (e.g., format('d M Y'))
    protected $casts = [
        'effective_from' => 'date',
        'effective_to'   => 'date',
    ];

    /**
     * Relationship: A price belongs to a specific Fuel Type.
     * This fixes the "Call to undefined relationship [fuelType]" error.
     */
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_id');
    }

    /**
     * Relationship: A price belongs to a specific Station (Optional).
     */
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }

    /**
     * Relationship: A price was changed by a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}