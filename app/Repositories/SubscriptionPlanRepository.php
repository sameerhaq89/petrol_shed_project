<?php

namespace App\Repositories;

use App\Interfaces\SubscriptionPlanRepositoryInterface;
use App\Models\SubscriptionPlan;

class SubscriptionPlanRepository implements SubscriptionPlanRepositoryInterface
{
    public function getAllPlans()
    {
        return SubscriptionPlan::orderBy('price')->get();
    }

    public function getActivePlans()
    {
        return SubscriptionPlan::active()->orderBy('price')->get();
    }

    public function getPlanById($id)
    {
        return SubscriptionPlan::findOrFail($id);
    }

    public function getPlanBySlug($slug)
    {
        return SubscriptionPlan::where('slug', $slug)->firstOrFail();
    }

    public function createPlan(array $data)
    {
        return SubscriptionPlan::create($data);
    }

    public function updatePlan($id, array $data)
    {
        $plan = $this->getPlanById($id);
        $plan->update($data);
        return $plan;
    }

    public function deletePlan($id)
    {
        $plan = $this->getPlanById($id);
        return $plan->delete();
    }

    public function togglePlanStatus($id)
    {
        $plan = $this->getPlanById($id);
        $plan->is_active = !$plan->is_active;
        $plan->save();
        return $plan;
    }
}
