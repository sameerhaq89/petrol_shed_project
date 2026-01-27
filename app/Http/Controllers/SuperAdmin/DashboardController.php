<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\StationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\StationSubscriptionRepositoryInterface;

class DashboardController extends Controller
{
    protected $stationRepository;
    protected $userRepository;
    protected $subscriptionRepository;

    public function __construct(
        StationRepositoryInterface $stationRepository,
        UserRepositoryInterface $userRepository,
        StationSubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->stationRepository = $stationRepository;
        $this->userRepository = $userRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function index()
    {
        $stats = [
            'total_stations' => $this->stationRepository->getAllStations()->count(),
            'active_subscriptions' => \App\Models\StationSubscription::active()->count(),
            'expiring_soon' => $this->subscriptionRepository->getExpiringSubscriptions(7)->count(),
            'total_revenue' => $this->calculateMonthlyRevenue(),
        ];

        $recentStations = $this->stationRepository->getAllStations()
            ->sortByDesc('created_at')
            ->take(5);

        $expiringSubscriptions = $this->subscriptionRepository->getExpiringSubscriptions(7);

        return view('super-admin.pages.dashboard', compact('stats', 'recentStations', 'expiringSubscriptions'));
    }

    private function calculateMonthlyRevenue()
    {
        return \App\Models\StationSubscription::whereMonth('station_subscriptions.created_at', now()->month)
            ->whereYear('station_subscriptions.created_at', now()->year)
            ->join('subscription_plans', 'station_subscriptions.subscription_plan_id', '=', 'subscription_plans.id')
            ->sum('subscription_plans.price');
    }
}
