<?php

/**
 * ========================================
 * SUBSCRIPTION SYSTEM CONFIGURATION GUIDE
 * ========================================
 * 
 * Follow these steps to complete the setup
 */

// ============================================
// STEP 1: Register Service Provider
// ============================================

/**
 * For Laravel 11+ (New Structure)
 * 
 * File: bootstrap/providers.php
 * 
 * Add this line to the return array:
 */
/*
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\SubscriptionServiceProvider::class, // Add this
];
*/

/**
 * For Laravel 10 and below
 * 
 * File: config/app.php
 * 
 * Add to the 'providers' array:
 */
/*
'providers' => [
    // ... other providers
    App\Providers\SubscriptionServiceProvider::class,
],
*/


// ============================================
// STEP 2: Register Middleware
// ============================================

/**
 * File: app/Http/Kernel.php
 * 
 * Add to $middlewareAliases array:
 */
/*
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    // ... other middleware
    
    // ADD THESE TWO LINES:
    'subscription' => \App\Http\Middleware\CheckSubscription::class,
    'addon' => \App\Http\Middleware\CheckAddon::class,
];
*/


// ============================================
// STEP 3: Update Station Model (Optional)
// ============================================

/**
 * File: app/Models/Station.php
 * 
 * Add these relationships:
 */
/*
use App\Models\StationSubscription;
use App\Models\Addon;

class Station extends Model
{
    // ... existing code
    
    // Add these relationships:
    
    public function subscriptions()
    {
        return $this->hasMany(StationSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(StationSubscription::class)
            ->where('status', 'active')
            ->where('end_date', '>=', now());
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'station_addons')
            ->withPivot('is_enabled', 'enabled_at')
            ->withTimestamps();
    }

    public function enabledAddons()
    {
        return $this->belongsToMany(Addon::class, 'station_addons')
            ->wherePivot('is_enabled', true)
            ->withPivot('enabled_at')
            ->withTimestamps();
    }
}
*/


// ============================================
// STEP 4: Example Route Protection
// ============================================

/**
 * File: routes/web.php
 * 
 * Examples of how to protect routes:
 */
/*
// Protect entire group with subscription check
Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/sales', [SalesController::class, 'index']);
});

// Protect specific features with addon check
Route::middleware(['auth', 'subscription', 'addon:tank-management'])->group(function () {
    Route::resource('tanks', TankController::class);
    Route::resource('dip-readings', DipReadingController::class);
});

Route::middleware(['auth', 'subscription', 'addon:inventory'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

Route::middleware(['auth', 'subscription', 'addon:reports'])->group(function () {
    Route::get('/reports/sales', [ReportController::class, 'sales']);
    Route::get('/reports/inventory', [ReportController::class, 'inventory']);
});

Route::middleware(['auth', 'subscription', 'addon:pumper-management'])->group(function () {
    Route::resource('pumpers', PumperController::class);
    Route::resource('shifts', ShiftController::class);
});
*/


// ============================================
// STEP 5: Example Blade Integration
// ============================================

/**
 * Show/hide menu items based on addons
 * 
 * File: resources/views/layouts/sidebar.blade.php
 */
/*
@inject('subscriptionService', 'App\Services\SubscriptionService')

@php
    $stationId = session('petrol_set_id');
@endphp

<ul class="sidebar-menu">
    {{-- Always visible --}}
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('sales') }}">Sales</a></li>
    
    {{-- Conditional based on addons --}}
    @if($subscriptionService->hasAddon($stationId, 'tank-management'))
        <li><a href="{{ route('tanks.index') }}">Tank Management</a></li>
    @endif
    
    @if($subscriptionService->hasAddon($stationId, 'inventory'))
        <li><a href="{{ route('inventory.index') }}">Inventory</a></li>
    @endif
    
    @if($subscriptionService->hasAddon($stationId, 'reports'))
        <li><a href="{{ route('reports.index') }}">Reports</a></li>
    @endif
    
    @if($subscriptionService->hasAddon($stationId, 'pumper-management'))
        <li><a href="{{ route('pumpers.index') }}">Pumper Management</a></li>
    @endif
</ul>

{{-- Show subscription warning if expiring soon --}}
@if($subscriptionService->isExpiringSoon($stationId))
    <div class="alert alert-warning">
        ⚠️ Your subscription expires in {{ $subscriptionService->getDaysRemaining($stationId) }} days!
    </div>
@endif
*/


// ============================================
// STEP 6: Example Controller Usage
// ============================================

/**
 * Using SubscriptionService in controllers
 */
/*
use App\Services\SubscriptionService;

class DashboardController extends Controller
{
    protected $subscriptionService;
    
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }
    
    public function index()
    {
        $stationId = session('petrol_set_id');
        
        // Check subscription
        $hasSubscription = $this->subscriptionService->hasActiveSubscription($stationId);
        
        // Get subscription details
        $subscription = $this->subscriptionService->getActiveSubscription($stationId);
        
        // Check specific addons
        $hasInventory = $this->subscriptionService->hasAddon($stationId, 'inventory');
        $hasReports = $this->subscriptionService->hasAddon($stationId, 'reports');
        
        // Get all enabled addons
        $enabledAddons = $this->subscriptionService->getEnabledAddons($stationId);
        
        // Get days remaining
        $daysRemaining = $this->subscriptionService->getDaysRemaining($stationId);
        
        return view('dashboard', compact(
            'hasSubscription',
            'subscription',
            'hasInventory',
            'hasReports',
            'enabledAddons',
            'daysRemaining'
        ));
    }
}
*/


// ============================================
// VERIFICATION COMMANDS
// ============================================

/**
 * After configuration, run these commands:
 */
/*
# Check if everything is configured correctly
php artisan subscription:check

# If you see errors, run:
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Then check again:
php artisan subscription:check
*/


// ============================================
// ADDON SLUG REFERENCE
// ============================================

/**
 * Available addon slugs (from seeder):
 */
/*
'tank-management'       - Tank Management
'settlement'           - Settlement
'settlement-list'      - Settlement List
'pump-management'      - Pump Management
'pumper-management'    - Pumper Management
'dip-management'       - Dip Management
'fuel-management'      - Fuel Management
'inventory'            - Inventory System
'reports'              - Advanced Reports
'price-visibility'     - Price Visibility
'bulk-upload'          - Bulk Upload
'customer-management'  - Customer Management
*/


// ============================================
// SUBSCRIPTION PLAN REFERENCE
// ============================================

/**
 * Available plans (from seeder):
 */
/*
'free-trial'    - Free Trial    - $0.00    - 7 days  - 0 addons
'basic-plan'    - Basic Plan    - $49.99   - 30 days - 1 addon
'standard-plan' - Standard Plan - $99.99   - 30 days - 3 addons
'premium-plan'  - Premium Plan  - $199.99  - 30 days - Unlimited addons
*/


// ============================================
// TROUBLESHOOTING
// ============================================

/**
 * Common Issues and Solutions:
 * 
 * 1. Routes not working
 *    Solution: php artisan route:clear
 * 
 * 2. Middleware not registered
 *    Solution: Check app/Http/Kernel.php
 * 
 * 3. Service Provider not loading
 *    Solution: php artisan config:clear
 * 
 * 4. Plans/Addons not showing
 *    Solution: Run seeders again
 * 
 * 5. 404 on super admin
 *    Solution: Check routes/super-admin.php is loaded
 */


// ============================================
// DONE! 🎉
// ============================================

/**
 * After completing all steps:
 * 
 * 1. Access Super Admin: http://yourdomain.com/super-admin/dashboard
 * 2. Create or manage subscription plans
 * 3. Create or manage addons
 * 4. Assign subscriptions to stations
 * 5. Enable addons for stations
 * 6. Test the middleware protection
 * 
 * For detailed documentation, see:
 * - QUICK_SETUP_GUIDE.md
 * - SUBSCRIPTION_SYSTEM_README.md
 * - IMPLEMENTATION_SUMMARY.md
 */
