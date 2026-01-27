# Quick Setup Guide - Subscription System

## ⚡ Quick Installation

Run this single command to install everything:

```bash
php artisan subscription:install
```

## 📝 Manual Configuration Steps

### 1. Register Service Provider

**Option A: Laravel 11+ (Recommended)**

Add to `bootstrap/providers.php`:
```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\SubscriptionServiceProvider::class, // Add this line
];
```

**Option B: Laravel 10 and below**

Add to `config/app.php` in the `providers` array:
```php
'providers' => [
    // ...
    App\Providers\SubscriptionServiceProvider::class,
],
```

### 2. Register Middleware

Add to `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // Existing middleware...
    'auth' => \App\Http\Middleware\Authenticate::class,
    
    // Add these two lines:
    'subscription' => \App\Http\Middleware\CheckSubscription::class,
    'addon' => \App\Http\Middleware\CheckAddon::class,
];
```

### 3. Update Station Model (Optional)

Add relationships to `app/Models/Station.php`:

```php
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
```

## 🔧 Usage in Routes

### Protect entire route group:
```php
Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/sales', [SalesController::class, 'index']);
});
```

### Protect specific addon features:
```php
// Tank Management routes
Route::middleware(['auth', 'subscription', 'addon:tank-management'])->group(function () {
    Route::resource('tanks', TankController::class);
});

// Inventory routes
Route::middleware(['auth', 'subscription', 'addon:inventory'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

// Reports routes
Route::middleware(['auth', 'subscription', 'addon:reports'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
});
```

## 🎨 Frontend Integration

### Check addon in blade views:
```blade
@inject('subscriptionService', 'App\Services\SubscriptionService')

@if($subscriptionService->hasAddon(session('petrol_set_id'), 'inventory'))
    <li>
        <a href="{{ route('inventory.index') }}">
            <i class="fas fa-boxes"></i> Inventory
        </a>
    </li>
@endif

@if($subscriptionService->hasAddon(session('petrol_set_id'), 'reports'))
    <li>
        <a href="{{ route('reports.index') }}">
            <i class="fas fa-chart-bar"></i> Reports
        </a>
    </li>
@endif
```

### Show subscription expiry warning:
```blade
@inject('subscriptionService', 'App\Services\SubscriptionService')

@if($subscriptionService->isExpiringSoon(session('petrol_set_id')))
    <div class="alert alert-warning">
        ⚠️ Your subscription expires in {{ $subscriptionService->getDaysRemaining(session('petrol_set_id')) }} days!
        Please contact your administrator.
    </div>
@endif
```

## 🔐 Super Admin Access

### Login as Super Admin
Navigate to: `http://yourdomain.com/super-admin/dashboard`

### Default Features:
- ✅ Manage Subscription Plans
- ✅ Manage Addons
- ✅ Assign Subscriptions to Stations
- ✅ Enable/Disable Addons per Station
- ✅ View Subscription History
- ✅ Monitor Expiring Subscriptions

## 📊 Available Addons (From Seeder)

1. `tank-management` - Tank Management
2. `settlement` - Settlement
3. `settlement-list` - Settlement List
4. `pump-management` - Pump Management
5. `pumper-management` - Pumper Management
6. `dip-management` - Dip Management
7. `fuel-management` - Fuel Management
8. `inventory` - Inventory System
9. `reports` - Advanced Reports
10. `price-visibility` - Price Visibility
11. `bulk-upload` - Bulk Upload
12. `customer-management` - Customer Management

## 🚨 Troubleshooting

### Subscription check not working?
1. Verify middleware is registered in Kernel.php
2. Check if session has 'petrol_set_id'
3. Ensure subscription is active in database

### Addon check failing?
1. Verify addon slug matches database
2. Check if addon is enabled in station_addons table
3. Ensure station has active subscription

### 404 on Super Admin routes?
1. Clear route cache: `php artisan route:clear`
2. Verify routes/super-admin.php is loaded
3. Check if route exists: `php artisan route:list`

## 📞 Quick Commands

```bash
# Install system
php artisan subscription:install

# Run migrations only
php artisan migrate

# Seed plans only
php artisan db:seed --class=SubscriptionPlanSeeder

# Seed addons only
php artisan db:seed --class=AddonSeeder

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## ✅ Verification Checklist

- [ ] Migrations created all tables
- [ ] Service provider registered
- [ ] Middleware registered in Kernel.php
- [ ] Subscription plans seeded
- [ ] Addons seeded
- [ ] Can access /super-admin/dashboard
- [ ] Can create new subscription plan
- [ ] Can assign subscription to station
- [ ] Can manage station addons
- [ ] Middleware blocks access correctly

---

**Need Help?** Check SUBSCRIPTION_SYSTEM_README.md for detailed documentation.
