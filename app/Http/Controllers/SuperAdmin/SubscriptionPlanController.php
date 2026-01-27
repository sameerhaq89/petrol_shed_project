<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\SubscriptionPlanRepositoryInterface;

class SubscriptionPlanController extends Controller
{
    protected $planRepository;

    public function __construct(SubscriptionPlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function index()
    {
        $plans = $this->planRepository->getAllPlans();
        return view('super-admin.pages.subscription-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('super-admin.pages.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:subscription_plans,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_addons' => 'required|integer|min:-1',
            'is_trial' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $this->planRepository->createPlan($validated);

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Subscription plan created successfully');
    }

    public function edit($id)
    {
        $plan = $this->planRepository->getPlanById($id);
        return view('super-admin.pages.subscription-plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:subscription_plans,slug,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_addons' => 'required|integer|min:-1',
            'is_trial' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $this->planRepository->updatePlan($id, $validated);

        return redirect()->route('super-admin.plans.index')
            ->with('success', 'Subscription plan updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->planRepository->deletePlan($id);
            return redirect()->route('super-admin.plans.index')
                ->with('success', 'Subscription plan deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('super-admin.plans.index')
                ->with('error', 'Cannot delete plan with active subscriptions');
        }
    }

    public function toggleStatus($id)
    {
        $plan = $this->planRepository->togglePlanStatus($id);
        $status = $plan->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('super-admin.plans.index')
            ->with('success', "Plan {$status} successfully");
    }
}
