<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\TankRepositoryInterface;
use App\Repositories\TankRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    
    $this->app->bind(
            TankRepositoryInterface::class,
            TankRepository::class
        );
    $this->app->bind(
        \App\Interfaces\PumpRepositoryInterface::class,
        \App\Repositories\PumpRepository::class
    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
