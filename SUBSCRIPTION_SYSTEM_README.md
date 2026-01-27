# Petrol Set SaaS - Subscription & Addon Management System

## 🎯 Overview

This implementation provides a complete subscription and addon management system for the Petrol Set SaaS platform with the following features:

- **Free Trial** - 7 days with no addons
- **Basic Plan** - 1 addon allowed
- **Standard Plan** - 3 addons allowed
- **Premium Plan** - Unlimited addons

## 📁 File Structure

### Database Migrations
```
database/migrations/
├── 2024_01_27_000001_create_subscription_plans_table.php
├── 2024_01_27_000002_create_addons_table.php
├── 2024_01_27_000003_create_station_subscriptions_table.php
└── 2024_01_27_000004_create_station_addons_table.php
```

### Models
```
app/Models/
├── SubscriptionPlan.php
├── Addon.php
├── StationSubscription.php
└── StationAddon.php
```

### Repositories & Interfaces
```
app/Interfaces/
├── SubscriptionPlanRepositoryInterface.php
├── AddonRepositoryInterface.php
├── StationSubscriptionRepositoryInterface.php
└── StationAddonRepositoryInterface.php

app/Repositories/
├── SubscriptionPlanRepository.php
├── AddonRepository.php
├── StationSubscriptionRepository.php
└── StationAddonRepository.php
```

### Controllers
```
app/Http/Controllers/SuperAdmin/
├── DashboardController.php
├── SubscriptionPlanController.php
├── AddonController.php
└── StationManagementController.php
```

### Middleware
```
app/Http/Middleware/
├── CheckSubscription.php
└── CheckAddon.php
```

### Views
```
resources/views/super-admin/pages/
├── dashboard.blade.php (updated)
├── subscription-plans/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── addons/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── stations/
    ├── index.blade.php
    ├── show.blade.php
    └── manage-addons.blade.php
```

### Services
```
app/Services/
└── SubscriptionService.php
```

### Seeders
```
database/seeders/
├── SubscriptionPlanSeeder.php
└── AddonSeeder.php
```

## 🚀 Installation & Setup

### Step 1: Run Migrations
```bash
php artisan migrate
```

### Step 2: Register Service Provider

Add to `config/app.php` in the `providers` array:
```php
App\Providers\SubscriptionServiceProvider::class,
```

Or if using Laravel 11+, add to `bootstrap/providers.php`:
```php
App\Providers\SubscriptionServiceProvider::class,
```

### Step 3: Register Middleware

Add to `app/Http/Kernel.php` in the `$middlewareAliases` array:
```php
protected $middlewareAliases = [
    // ... existing middleware
    'subscription' => \App\Http\Middleware\CheckSubscription::class,
    'addon' => \App\Http\Middleware\CheckAddon::class,
];
```

### Step 4: Seed Default Data
```bash
php artisan db:seed --class=SubscriptionPlanSeeder
php artisan db:seed --class=AddonSeeder
```

## 📊 Database Schema

### Subscription Plans
- **Free Trial**: $0, 7 days, 0 addons
- **Basic**: $49.99, 30 days, 1 addon
- **Standard**: $99.99, 30 days, 3 addons
- **Premium**: $199.99, 30 days, unlimited addons

### Default Addons
1. Tank Management
2. Settlement
3. Settlement List
4. Pump Management
5. Pumper Management
6. Dip Management
7. Fuel Management
8. Inventory System
9. Advanced Reports
10. Price Visibility
11. Bulk Upload
12. Customer Management

## 🔐 Usage Examples

### Protecting Routes with Subscription Check
```php
Route::middleware(['auth', 'subscription'])->group(function () {
    // Protected routes
});
```

### Protecting Routes with Addon Check
```php
// Single addon check
Route::middleware(['auth', 'subscription', 'addon:inventory'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index']);
});

// Multiple checks
Route::get('/reports', [ReportController::class, 'index'])
    ->middleware(['auth', 'subscription', 'addon:reports']);
```

### Using Subscription Service in Controllers
```php
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
        
        // Check if has active subscription
        $hasSubscription = $this->subscriptionService->hasActiveSubscription($stationId);
        
        // Check if addon is enabled
        $hasInventory = $this->subscriptionService->hasAddon($stationId, 'inventory');
        
        // Get days remaining
        $daysRemaining = $this->subscriptionService->getDaysRemaining($stationId);
        
        // Check if expiring soon
        $isExpiring = $this->subscriptionService->isExpiringSoon($stationId);
        
        return view('dashboard', compact('hasSubscription', 'hasInventory', 'daysRemaining', 'isExpiring'));
    }
}
```

### Using in Blade Templates
```blade
@if($subscriptionService->hasAddon(session('petrol_set_id'), 'inventory'))
    <a href="{{ route('inventory.index') }}">Inventory</a>
@else
    <span class="disabled">Inventory (Upgrade Required)</span>
@endif
```

## 🎨 Super Admin Features

### Dashboard
- View total stations
- Active subscriptions count
- Expiring subscriptions alert
- Monthly revenue

### Subscription Plans Management
- Create/Edit/Delete plans
- Activate/Deactivate plans
- Set pricing and duration
- Configure addon limits

### Addons Management
- Create/Edit/Delete addons
- Activate/Deactivate addons
- Set icons and descriptions
- Reorder addons

### Station Management
- View all stations
- Assign subscriptions to stations
- Manage station addons
- View subscription history
- Monitor addon usage

## 🔄 Subscription Flow

1. Super Admin creates subscription plans
2. Super Admin creates addons
3. Super Admin assigns subscription to a station
4. Super Admin enables addons for the station (within plan limits)
5. Station users access features based on enabled addons
6. Middleware checks subscription validity and addon access
7. Subscription expires, access is blocked
8. Super Admin can renew or upgrade subscription

## 📝 Routes

### Super Admin Routes
```
GET     /super-admin/dashboard
GET     /super-admin/plans
GET     /super-admin/plans/create
POST    /super-admin/plans
GET     /super-admin/plans/{id}/edit
PUT     /super-admin/plans/{id}
DELETE  /super-admin/plans/{id}
PATCH   /super-admin/plans/{id}/toggle-status

GET     /super-admin/addons
GET     /super-admin/addons/create
POST    /super-admin/addons
GET     /super-admin/addons/{id}/edit
PUT     /super-admin/addons/{id}
DELETE  /super-admin/addons/{id}
PATCH   /super-admin/addons/{id}/toggle-status

GET     /super-admin/stations
GET     /super-admin/stations/{id}
POST    /super-admin/stations/{id}/assign-subscription
GET     /super-admin/stations/{id}/manage-addons
PUT     /super-admin/stations/{id}/update-addons
```

## 🛡️ Security Features

- Super admin bypass for all checks
- Session-based station isolation
- Server-side permission enforcement
- Audit-ready structure
- Subscription expiry validation
- Addon limit enforcement

## 📈 Future Enhancements

- Stripe payment integration
- Auto-renewal system
- Usage-based billing
- Subscription pause/resume
- Addon marketplace
- Custom plan creation
- Multi-currency support
- Invoice generation
- Email notifications for expiry
- Webhook support

## 🔧 Customization

### Adding New Plans
Edit `database/seeders/SubscriptionPlanSeeder.php` and run:
```bash
php artisan db:seed --class=SubscriptionPlanSeeder
```

### Adding New Addons
Edit `database/seeders/AddonSeeder.php` and run:
```bash
php artisan db:seed --class=AddonSeeder
```

## 📞 Support

For issues or questions:
1. Check the documentation
2. Review the code comments
3. Check middleware configuration
4. Verify database migrations ran successfully

## ✅ Testing Checklist

- [ ] Migrations run successfully
- [ ] Service provider registered
- [ ] Middleware registered
- [ ] Seeders run successfully
- [ ] Super admin can create plans
- [ ] Super admin can create addons
- [ ] Super admin can assign subscriptions
- [ ] Super admin can manage station addons
- [ ] Subscription middleware blocks expired access
- [ ] Addon middleware blocks unauthorized features
- [ ] Dashboard shows correct statistics

## 📄 License

This implementation is part of the Petrol Set SaaS project.

---

**Version:** 1.0.0  
**Last Updated:** January 27, 2026  
**Framework:** Laravel  
**Architecture:** Multi-tenant SaaS with Subscription Management
