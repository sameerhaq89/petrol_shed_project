<?php

namespace App\Services;

use App\Repositories\StationSubscriptionRepository;
use App\Repositories\StationAddonRepository;

class SubscriptionService
{
    protected $subscriptionRepository;
    protected $addonRepository;

    public function __construct(
        StationSubscriptionRepository $subscriptionRepository,
        StationAddonRepository $addonRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->addonRepository = $addonRepository;
    }

    /**
     * Check if station has active subscription
     */
    public function hasActiveSubscription($stationId): bool
    {
        return $this->subscriptionRepository->checkSubscriptionValidity($stationId);
    }

    /**
     * Get active subscription for station
     */
    public function getActiveSubscription($stationId)
    {
        return $this->subscriptionRepository->getStationActiveSubscription($stationId);
    }

    /**
     * Check if addon is enabled for station
     */
    public function hasAddon($stationId, string $addonSlug): bool
    {
        return $this->addonRepository->isAddonEnabled($stationId, $addonSlug);
    }

    /**
     * Get all enabled addons for station
     */
    public function getEnabledAddons($stationId)
    {
        return $this->addonRepository->getEnabledAddons($stationId);
    }

    /**
     * Check if station can add more addons based on plan
     */
    public function canAddMoreAddons($stationId): bool
    {
        $subscription = $this->getActiveSubscription($stationId);
        
        if (!$subscription) {
            return false;
        }

        $plan = $subscription->plan;
        
        // Unlimited addons
        if ($plan->hasUnlimitedAddons()) {
            return true;
        }

        $currentAddonCount = $this->getEnabledAddons($stationId)->count();
        
        return $currentAddonCount < $plan->max_addons;
    }

    /**
     * Get days remaining in subscription
     */
    public function getDaysRemaining($stationId): int
    {
        $subscription = $this->getActiveSubscription($stationId);
        
        if (!$subscription) {
            return 0;
        }

        return $subscription->daysRemaining();
    }

    /**
     * Check if subscription is expiring soon (within 7 days)
     */
    public function isExpiringSoon($stationId): bool
    {
        $daysRemaining = $this->getDaysRemaining($stationId);
        return $daysRemaining > 0 && $daysRemaining <= 7;
    }
}
