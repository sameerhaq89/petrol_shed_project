<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\StationSubscriptionRepository;

class CheckSubscription
{
    protected $subscriptionRepository;

    public function __construct(StationSubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip for users without station (e.g., super admin with role_id = 1)
        if (!$user || !$user->station_id) {
            return $next($request);
        }

        // Check subscription validity for the user's station
        $isValid = $this->subscriptionRepository->checkSubscriptionValidity($user->station_id);

        if (!$isValid) {
            return redirect()->route('subscription.expired')
                ->with('error', 'Your subscription has expired. Please contact administrator.');
        }

        return $next($request);
    }
}
