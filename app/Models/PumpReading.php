<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumpReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'pump_id',
        'opening_reading',
        'closing_reading',
        'total_volume',
        'current_price',
        'total_amount',
        'test_volume', // Optional: if you deduct testing liters
        'notes'
    ];

    /**
     * Link to the Shift (Daily Record)
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Link to the Pump
     */
    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }
}