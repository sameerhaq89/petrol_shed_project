<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get stations using this addon
     */
    public function stations()
    {
        return $this->belongsToMany(Station::class, 'station_addons')
            ->withPivot('is_enabled', 'enabled_at')
            ->withTimestamps();
    }

    /**
     * Scope: Active addons only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
