<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\SubscriptionPlanRepositoryInterface;
use App\Repositories\SubscriptionPlanRepository;
use App\Interfaces\AddonRepositoryInterface;
use App\Repositories\AddonRepository;
use App\Interfaces\StationSubscriptionRepositoryInterface;
use App\Repositories\StationSubscriptionRepository;
use App\Interfaces\StationAddonRepositoryInterface;
use App\Repositories\StationAddonRepository;
use App\Interfaces\StationRepositoryInterface;
use App\Repositories\StationRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

class SubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionPlanRepositoryInterface::class, SubscriptionPlanRepository::class);
        $this->app->bind(AddonRepositoryInterface::class, AddonRepository::class);
        $this->app->bind(StationSubscriptionRepositoryInterface::class, StationSubscriptionRepository::class);
        $this->app->bind(StationAddonRepositoryInterface::class, StationAddonRepository::class);
        $this->app->bind(StationRepositoryInterface::class, StationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register Blade directive for addon checking
        \Blade::if('hasAddon', function ($addonSlug) {
            $user = auth()->user();
            if (!$user) {
                return false;
            }
            
            // Users without station assignment cannot access addons
            if (!$user->station_id) {
                return false;
            }
            
            $service = app(\App\Services\SubscriptionService::class);
            return $service->hasAddon($user->station_id, $addonSlug);
        });
    }
}
