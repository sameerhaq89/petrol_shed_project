<?php

namespace App\Repositories;

use App\Interfaces\StationSubscriptionRepositoryInterface;
use App\Models\StationSubscription;
use Carbon\Carbon;

class StationSubscriptionRepository implements StationSubscriptionRepositoryInterface
{
    public function getStationActiveSubscription($stationId)
    {
        return StationSubscription::where('station_id', $stationId)
            ->active()
            ->with('plan')
            ->first();
    }

    public function getStationSubscriptionHistory($stationId)
    {
        return StationSubscription::where('station_id', $stationId)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createSubscription(array $data)
    {
        return StationSubscription::create($data);
    }

    public function updateSubscription($id, array $data)
    {
        $subscription = StationSubscription::findOrFail($id);
        $subscription->update($data);
        return $subscription;
    }

    public function cancelSubscription($id)
    {
        $subscription = StationSubscription::findOrFail($id);
        $subscription->status = 'cancelled';
        $subscription->save();
        return $subscription;
    }

    public function renewSubscription($id)
    {
        $subscription = StationSubscription::findOrFail($id);
        $plan = $subscription->plan;
        
        $newSubscription = StationSubscription::create([
            'station_id' => $subscription->station_id,
            'subscription_plan_id' => $subscription->subscription_plan_id,
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays($plan->duration_days),
            'status' => 'active',
            'auto_renew' => $subscription->auto_renew,
        ]);

        $subscription->status = 'expired';
        $subscription->save();

        return $newSubscription;
    }

    public function checkSubscriptionValidity($stationId)
    {
        $subscription = $this->getStationActiveSubscription($stationId);
        
        if (!$subscription) {
            return false;
        }

        if ($subscription->isExpired()) {
            $subscription->status = 'expired';
            $subscription->save();
            return false;
        }

        return true;
    }

    public function getExpiringSubscriptions($days = 7)
    {
        $endDate = Carbon::today()->addDays($days);
        
        return StationSubscription::active()
            ->where('end_date', '<=', $endDate)
            ->where('end_date', '>=', Carbon::today())
            ->with(['station', 'plan'])
            ->get();
    }
}
