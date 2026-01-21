<?php

namespace App\Providers;

use App\Interfaces\CashDropRepositoryInterface;
use App\Interfaces\DipReadingRepositoryInterface;
use App\Interfaces\FuelPriceRepositoryInterface;
use App\Interfaces\FuelTypeRepositoryInterface;
use App\Interfaces\PumperRepositoryInterface;
// Interfaces & Repositories
use App\Interfaces\PumpRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\SettlementListRepositoryInterface;
use App\Interfaces\ShiftRepositoryInterface;
use App\Interfaces\TankRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\VarianceRepositoryInterface;
use App\Models\Pump;
use App\Models\PumpOperatorAssignment;
use App\Models\Shift;
use App\Models\User;
use App\Repositories\CashDropRepository;
use App\Repositories\DipReadingRepository;
use App\Repositories\FuelPriceRepository;
use App\Repositories\FuelTypeRepository;
use App\Repositories\PumperRepository;
use App\Repositories\PumpRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SettlementListRepository;
use App\Repositories\ShiftRepository;
use App\Repositories\TankRepository;
use App\Repositories\UserRepository;
use App\Repositories\VarianceRepository;
// Models
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
            PumpRepositoryInterface::class,
            PumpRepository::class
        );
        $this->app->bind(
            DipReadingRepositoryInterface::class,
            DipReadingRepository::class
        );
        $this->app->bind(
            CashDropRepositoryInterface::class,
            CashDropRepository::class
        );
        $this->app->bind(
            FuelPriceRepositoryInterface::class,
            FuelPriceRepository::class
        );
        $this->app->bind(
            FuelTypeRepositoryInterface::class,
            FuelTypeRepository::class
        );
        $this->app->bind(
            PumperRepositoryInterface::class,
            PumperRepository::class
        );
        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        $this->app->bind(
            SettlementListRepositoryInterface::class,
            SettlementListRepository::class
        );
        $this->app->bind(
            ShiftRepositoryInterface::class,
            ShiftRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            VarianceRepositoryInterface::class,
            VarianceRepository::class
        );
    }

    public function boot(): void
    {
        // ---------------------------------------------------------
        // 1. PERMISSIONS & GATES
        // ---------------------------------------------------------

        // Super Admin Bypass: Always allow everything
        Gate::before(function ($user, $ability) {
            if ($user->role_id === 1) {
                return true;
            }
        });

        // Generic Permission Check
        Gate::define('check-permission', function (User $user, $permission) {
            return $user->hasPermission($permission);
        });

        // ---------------------------------------------------------
        // 2. VIEW COMPOSERS (Inject Data into Views)
        // ---------------------------------------------------------

        /**
         * Composer 1: Add Meter Sale Component
         * Injects: $activeShift, $quickPumps
         */
        View::composer('components.add-meter-sale', function ($view) {
            $user = Auth::user();
            $stationId = $user->station_id ?? 1;

            $activeShift = Shift::where('station_id', $stationId)
                ->where('status', 'open')
                ->latest()
                ->first();

            $pumps = Pump::with('tank.fuelType')
                ->where('station_id', $stationId)
                ->where('status', 'active')
                ->get();

            $view->with('activeShift', $activeShift)
                ->with('quickPumps', $pumps);
        });

        /**
         * Composer 2: Assign Pumper Modal (Global Quick Action)
         * Injects: $pumpers, $availablePumps
         * Fixes "Undefined variable" error on Dashboard/Fuel Prices pages
         */
        View::composer('admin.petro.pumper-management.modals.assign-pumper', function ($view) {

            $busyPumperIds = PumpOperatorAssignment::where('status', 'active')
                ->pluck('user_id')
                ->toArray();

            $pumpers = User::where('role_id', 3)
                ->where('is_active', 1)
                ->whereNotIn('id', $busyPumperIds)
                ->get();

            $busyPumpIds = PumpOperatorAssignment::where('status', 'active')
                ->pluck('pump_id')
                ->toArray();

            $availablePumps = Pump::whereNotIn('id', $busyPumpIds)
                ->where('status', 'active')
                ->get();

            $view->with(compact('pumpers', 'availablePumps'));
        });
    }
}
