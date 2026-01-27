<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\StationAddonRepository;

class CheckAddon
{
    protected $addonRepository;

    public function __construct(StationAddonRepository $addonRepository)
    {
        $this->addonRepository = $addonRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param string $addonSlug The slug of the addon to check
     */
    public function handle(Request $request, Closure $next, string $addonSlug): Response
    {
        // Skip for super admin
        if ($request->user() && $request->user()->role === 'super_admin') {
            return $next($request);
        }

        // Get current station ID from session
        $stationId = session('petrol_set_id');

        if (!$stationId) {
            abort(403, 'No station selected.');
        }

        // Check if addon is enabled for this station
        $isEnabled = $this->addonRepository->isAddonEnabled($stationId, $addonSlug);

        if (!$isEnabled) {
            abort(403, 'This feature is not available in your current plan. Please upgrade to access this feature.');
        }

        return $next($request);
    }
}
