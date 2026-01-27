<?php

namespace App\Interfaces;

interface SubscriptionPlanRepositoryInterface
{
    public function getAllPlans();
    public function getActivePlans();
    public function getPlanById($id);
    public function getPlanBySlug($slug);
    public function createPlan(array $data);
    public function updatePlan($id, array $data);
    public function deletePlan($id);
    public function togglePlanStatus($id);
}
