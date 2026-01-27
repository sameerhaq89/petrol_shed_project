# ✅ Installation Checklist - Subscription System

## Quick Start (Recommended)

```bash
# Step 1: Run automated installation
php artisan subscription:install

# Step 2: Verify installation
php artisan subscription:check

# Step 3: Configure manually (see below)
```

---

## 📋 Manual Configuration Checklist

### ☐ Step 1: Service Provider Registration

**For Laravel 11+:**
- [ ] Open `bootstrap/providers.php`
- [ ] Add `App\Providers\SubscriptionServiceProvider::class,`
- [ ] Save file

**For Laravel 10 and below:**
- [ ] Open `config/app.php`
- [ ] Find `'providers'` array
- [ ] Add `App\Providers\SubscriptionServiceProvider::class,`
- [ ] Save file

**Verify:**
```bash
php artisan config:clear
php artisan subscription:check
```

---

### ☐ Step 2: Middleware Registration

- [ ] Open `app/Http/Kernel.php`
- [ ] Find `protected $middlewareAliases` array
- [ ] Add these two lines:
```php
'subscription' => \App\Http\Middleware\CheckSubscription::class,
'addon' => \App\Http\Middleware\CheckAddon::class,
```
- [ ] Save file

**Verify:**
```bash
php artisan route:clear
php artisan subscription:check
```

---

### ☐ Step 3: Station Model Update (Optional but Recommended)

- [ ] Open `app/Models/Station.php`
- [ ] Add these relationships:
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
- [ ] Add use statements:
```php
use App\Models\StationSubscription;
use App\Models\Addon;
```
- [ ] Save file

---

### ☐ Step 4: Clear All Caches

Run these commands:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**Check each:**
- [ ] Config cleared
- [ ] Cache cleared
- [ ] Routes cleared
- [ ] Views cleared

---

### ☐ Step 5: Verify Installation

```bash
php artisan subscription:check
```

**Expected output:**
- ✅ All database tables exist
- ✅ Service provider registered
- ✅ Middleware registered
- ✅ Plans and addons seeded
- ✅ Routes exist
- ✅ Views exist

---

## 🧪 Quick Test

### Test 1: Access Super Admin Dashboard

```
URL: http://yourdomain.com/super-admin/dashboard
```

**Check:**
- [ ] Page loads without errors
- [ ] Statistics display
- [ ] Sidebar navigation visible
- [ ] No console errors

### Test 2: View Subscription Plans

```
URL: http://yourdomain.com/super-admin/plans
```

**Check:**
- [ ] 4 default plans visible
- [ ] Can click "Add New Plan"
- [ ] Plans show correct data

### Test 3: View Addons

```
URL: http://yourdomain.com/super-admin/addons
```

**Check:**
- [ ] 12 default addons visible
- [ ] Icons display correctly
- [ ] Can click "Add New Addon"

### Test 4: View Stations

```
URL: http://yourdomain.com/super-admin/stations
```

**Check:**
- [ ] Stations list loads
- [ ] Can click on station
- [ ] Station details page works

---

## 🔧 Route Protection (Optional)

To protect existing routes with subscription/addon checks:

### Example 1: Protect Dashboard
```php
// In routes/web.php
Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

### Example 2: Protect Feature with Addon
```php
// In routes/web.php
Route::middleware(['auth', 'subscription', 'addon:inventory'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});
```

**Apply to your routes:**
- [ ] Identify routes to protect
- [ ] Add middleware
- [ ] Test access control

---

## 📱 Frontend Integration (Optional)

### Update Sidebar Navigation

- [ ] Open your sidebar blade file
- [ ] Add subscription service injection:
```blade
@inject('subscriptionService', 'App\Services\SubscriptionService')
```

- [ ] Add conditional menu items:
```blade
@if($subscriptionService->hasAddon(session('petrol_set_id'), 'inventory'))
    <li><a href="{{ route('inventory.index') }}">Inventory</a></li>
@endif
```

### Add Expiry Warning

- [ ] Open your dashboard blade
- [ ] Add warning:
```blade
@if($subscriptionService->isExpiringSoon(session('petrol_set_id')))
    <div class="alert alert-warning">
        Your subscription expires in {{ $subscriptionService->getDaysRemaining(session('petrol_set_id')) }} days!
    </div>
@endif
```

---

## 🗄️ Database Verification

Run these SQL queries to verify:

```sql
-- Check plans
SELECT COUNT(*) FROM subscription_plans; -- Should be 4

-- Check addons  
SELECT COUNT(*) FROM addons; -- Should be 12

-- Check tables exist
SHOW TABLES LIKE 'station_%';
-- Should show: station_subscriptions, station_addons
```

**Verify:**
- [ ] 4 subscription plans
- [ ] 12 addons
- [ ] All tables created

---

## 📝 Documentation Review

Read these files for reference:

- [ ] `QUICK_SETUP_GUIDE.md` - Fast setup instructions
- [ ] `SUBSCRIPTION_SYSTEM_README.md` - Complete documentation
- [ ] `IMPLEMENTATION_SUMMARY.md` - Feature overview
- [ ] `TESTING_GUIDE.md` - Test scenarios
- [ ] `FILE_INDEX.md` - All files created

---

## 🎯 Assignment Test (Real Usage)

### Create First Subscription

1. **Go to Super Admin Dashboard**
   - [ ] Access `/super-admin/dashboard`

2. **Go to Stations**
   - [ ] Click "Stations" in sidebar
   - [ ] Click on a test station

3. **Assign Subscription**
   - [ ] Click "Assign New Subscription"
   - [ ] Select "Basic Plan"
   - [ ] Set start date to today
   - [ ] Click "Assign Subscription"
   - [ ] Verify success message

4. **Enable Addon**
   - [ ] Click "Manage Addons"
   - [ ] Select 1 addon (Basic allows 1)
   - [ ] Click "Save Addons"
   - [ ] Verify addon appears in station details

5. **Test Middleware**
   - [ ] Protect a route with `addon:YOUR_SELECTED_ADDON`
   - [ ] Try to access it
   - [ ] Should work (addon enabled)
   - [ ] Try different addon
   - [ ] Should block (addon not enabled)

---

## 🐛 Troubleshooting

### Issue: Routes not found (404)

**Solution:**
```bash
php artisan route:clear
php artisan route:cache
php artisan route:list | grep super-admin
```

**Check:**
- [ ] Routes listed correctly
- [ ] Cache cleared

---

### Issue: Service provider not loading

**Solution:**
```bash
php artisan config:clear
php artisan config:cache
composer dump-autoload
```

**Check:**
- [ ] Config cleared
- [ ] Autoload regenerated

---

### Issue: Middleware not working

**Solution:**
1. Check `app/Http/Kernel.php` has aliases
2. Clear route cache
3. Verify session has `petrol_set_id`

**Verify:**
```php
// In controller
dd(session('petrol_set_id'));
```

**Check:**
- [ ] Session has station ID
- [ ] Middleware aliases correct
- [ ] Route uses correct middleware

---

### Issue: Views not found

**Solution:**
```bash
php artisan view:clear
php artisan view:cache
```

**Check:**
- [ ] Views in correct directory
- [ ] Namespace correct
- [ ] Cache cleared

---

## ✅ Final Verification

Run complete check:
```bash
php artisan subscription:check
```

**All checks should pass:**
- ✅ Database migrations
- ✅ Service provider
- ✅ Middleware
- ✅ Seeded data
- ✅ Routes
- ✅ Views

---

## 🎉 Success Criteria

Installation is complete when:

- [x] All migrations run successfully
- [x] Service provider registered
- [x] Middleware registered
- [x] 4 plans seeded
- [x] 12 addons seeded
- [x] Super admin dashboard accessible
- [x] Can create/edit plans
- [x] Can create/edit addons
- [x] Can assign subscriptions
- [x] Can manage station addons
- [x] Middleware blocks correctly
- [x] No errors in logs

---

## 📞 Getting Help

If you encounter issues:

1. **Run diagnostics:**
   ```bash
   php artisan subscription:check
   ```

2. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Review documentation:**
   - Quick Setup Guide
   - Troubleshooting section

4. **Clear all caches:**
   ```bash
   php artisan optimize:clear
   ```

---

## 🚀 You're Ready!

Once all checkboxes are ticked, your Subscription System is fully installed and ready to use!

**Next Steps:**
1. Access super admin panel
2. Review subscription plans
3. Customize as needed
4. Assign to stations
5. Start using the system!

---

**Installation Date:** ____________

**Installed By:** ____________

**Status:** ☐ Complete ☐ In Progress ☐ Issues

**Notes:**
____________________________________________
____________________________________________
____________________________________________

---

✨ **Happy Managing!** ✨
