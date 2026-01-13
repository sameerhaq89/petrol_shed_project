<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Optional, if you use soft deletes

class Pump extends Model
{
    use HasFactory; 
    // use SoftDeletes; // Uncomment if your table has deleted_at

    protected $table = 'pumps';

    // Ensure all your fillable fields are listed here
    protected $fillable = [
        'pump_name',
        'pump_number',
        'tank_id',
        'status',
        'last_meter_reading',
        'notes'
    ];

    /**
     * Relationship: A Pump belongs to one Tank.
     */
    public function tank()
    {
        // This assumes your pumps table has a 'tank_id' column
        return $this->belongsTo(Tank::class, 'tank_id');
    }
}