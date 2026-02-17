<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DipReading extends Model
{
    use HasFactory;

    // Matches your SQL Dump columns exactly
    protected $fillable = [
        'station_id',
        'tank_id',
        'reading_date',
        'dip_level_cm',
        'volume_liters',
        'temperature',
        'notes',
        'recorded_by'
    ];

    protected $casts = [
        'reading_date' => 'date',
        'dip_level_cm' => 'decimal:2',
        'volume_liters' => 'decimal:2',
        'temperature' => 'decimal:2',
    ];

    // Relationships
    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function recorder()
    {
        // 'recorded_by' is the column name in your DB
        return $this->belongsTo(User::class, 'recorded_by');
    }
}