<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\StationRepositoryInterface;
use App\Interfaces\StationSubscriptionRepositoryInterface;
use App\Interfaces\SubscriptionPlanRepositoryInterface;
use App\Interfaces\StationAddonRepositoryInterface;
use App\Interfaces\AddonRepositoryInterface;
use Carbon\Carbon;

class StationManagementController extends Controller
{
    protected $stationRepository;
    protected $subscriptionRepository;
    protected $planRepository;
    protected $stationAddonRepository;
    protected $addonRepository;

    public function __construct(
        StationRepositoryInterface $stationRepository,
        StationSubscriptionRepositoryInterface $subscriptionRepository,
        SubscriptionPlanRepositoryInterface $planRepository,
        StationAddonRepositoryInterface $stationAddonRepository,
        AddonRepositoryInterface $addonRepository
    ) {
        $this->stationRepository = $stationRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->planRepository = $planRepository;
        $this->stationAddonRepository = $stationAddonRepository;
        $this->addonRepository = $addonRepository;
    }

    public function index()
    {
        $stations = $this->stationRepository->getAllStations();
        
        // Load subscriptions for each station
        foreach ($stations as $station) {
            $station->activeSubscription = $this->subscriptionRepository->getStationActiveSubscription($station->id);
        }

        return view('super-admin.pages.stations.index', compact('stations'));
    }

    public function show($id)
    {
        $station = $this->stationRepository->getStationById($id);
        $activeSubscription = $this->subscriptionRepository->getStationActiveSubscription($id);
        $subscriptionHistory = $this->subscriptionRepository->getStationSubscriptionHistory($id);
        $stationAddons = $this->stationAddonRepository->getEnabledAddons($id);

        return view('super-admin.pages.stations.show', compact(
            'station',
            'activeSubscription',
            'subscriptionHistory',
            'stationAddons'
        ));
    }

    public function assignSubscription(Request $request, $stationId)
    {
        $validated = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'nullable|date',
        ]);

        $plan = $this->planRepository->getPlanById($validated['subscription_plan_id']);
        $startDate = $validated['start_date'] ?? Carbon::today();

        // Cancel existing active subscription
        $existingSubscription = $this->subscriptionRepository->getStationActiveSubscription($stationId);
        if ($existingSubscription) {
            $this->subscriptionRepository->cancelSubscription($existingSubscription->id);
        }

        // Create new subscription
        $this->subscriptionRepository->createSubscription([
            'station_id' => $stationId,
            'subscription_plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => Carbon::parse($startDate)->addDays($plan->duration_days),
            'status' => 'active',
        ]);

        return redirect()->route('super-admin.stations.show', $stationId)
            ->with('success', 'Subscription assigned successfully');
    }

    public function manageAddons($stationId)
    {
        $station = $this->stationRepository->getStationById($stationId);
        $activeSubscription = $this->subscriptionRepository->getStationActiveSubscription($stationId);
        $allAddons = $this->addonRepository->getActiveAddons();
        $enabledAddons = $this->stationAddonRepository->getEnabledAddons($stationId);
        $enabledAddonIds = $enabledAddons->pluck('addon_id')->toArray();

        return view('super-admin.pages.stations.manage-addons', compact(
            'station',
            'activeSubscription',
            'allAddons',
            'enabledAddonIds'
        ));
    }

    public function updateAddons(Request $request, $stationId)
    {
        $validated = $request->validate([
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
        ]);

        $activeSubscription = $this->subscriptionRepository->getStationActiveSubscription($stationId);
        
        if (!$activeSubscription) {
            return redirect()->back()->with('error', 'Station has no active subscription');
        }

        $plan = $activeSubscription->plan;
        $selectedAddons = $validated['addons'] ?? [];

        // Check addon limit
        if (!$plan->hasUnlimitedAddons() && count($selectedAddons) > $plan->max_addons) {
            return redirect()->back()->with('error', "This plan allows only {$plan->max_addons} addon(s)");
        }

        $this->stationAddonRepository->syncStationAddons($stationId, $selectedAddons);

        return redirect()->route('super-admin.stations.show', $stationId)
            ->with('success', 'Addons updated successfully');
    }
}
