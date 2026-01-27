<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration_days',
        'max_addons',
        'is_trial',
        'is_active',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_trial' => 'boolean',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get all subscriptions for this plan
     */
    public function subscriptions()
    {
        return $this->hasMany(StationSubscription::class);
    }

    /**
     * Check if plan is unlimited addons
     */
    public function hasUnlimitedAddons(): bool
    {
        return $this->max_addons === -1;
    }

    /**
     * Scope: Active plans only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Non-trial plans
     */
    public function scopePaid($query)
    {
        return $query->where('is_trial', false);
    }
}
