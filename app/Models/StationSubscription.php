<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StationSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'status',
        'auto_renew',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_renew' => 'boolean',
    ];

    /**
     * Get the station for this subscription
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Get the subscription plan
     */
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->end_date >= Carbon::today();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return $this->end_date < Carbon::today();
    }

    /**
     * Get days remaining
     */
    public function daysRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }
        return Carbon::today()->diffInDays($this->end_date, false);
    }

    /**
     * Scope: Active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>=', Carbon::today());
    }

    /**
     * Scope: Expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', Carbon::today());
    }
}
