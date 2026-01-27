<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'addon_id',
        'is_enabled',
        'enabled_at',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'enabled_at' => 'datetime',
    ];

    /**
     * Get the station
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Get the addon
     */
    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
