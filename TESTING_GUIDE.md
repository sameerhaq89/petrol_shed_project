# 🧪 Subscription System - Testing Guide

## Pre-Testing Setup

### 1. Installation Check
```bash
# Run the setup verification
php artisan subscription:check
```

All checks should pass before testing.

### 2. Access Credentials
Make sure you have:
- Super admin account credentials
- Test station(s) in database
- Browser access to the application

---

## 🎯 Test Scenarios

### Test 1: Super Admin Dashboard Access

**Steps:**
1. Navigate to `/super-admin/dashboard`
2. Verify you can see the dashboard
3. Check statistics are displaying correctly

**Expected Results:**
- ✅ Dashboard loads without errors
- ✅ Stats show: Total Stations, Active Subscriptions, Expiring Soon, Monthly Revenue
- ✅ Recent stations table displays
- ✅ Sidebar navigation is visible

---

### Test 2: Subscription Plans Management

#### 2A: View Plans
**Steps:**
1. Click "Subscription Plans" in sidebar
2. Verify plans are listed

**Expected Results:**
- ✅ 4 default plans visible (Free Trial, Basic, Standard, Premium)
- ✅ Each plan shows price, duration, and addon limit
- ✅ Status badges display correctly (Active/Inactive)

#### 2B: Create New Plan
**Steps:**
1. Click "Add New Plan"
2. Fill in form:
   - Name: "Test Plan"
   - Slug: "test-plan" (auto-generated)
   - Price: 75.00
   - Duration: 30
   - Max Addons: 2
   - Check "Active"
3. Click "Create Plan"

**Expected Results:**
- ✅ Success message appears
- ✅ Redirected to plans list
- ✅ New plan appears in grid
- ✅ Plan data is correct

#### 2C: Edit Plan
**Steps:**
1. Click "Edit" on test plan
2. Change price to 79.99
3. Click "Update Plan"

**Expected Results:**
- ✅ Success message appears
- ✅ Price updated correctly

#### 2D: Toggle Plan Status
**Steps:**
1. Click "Deactivate" on test plan
2. Verify badge changes to "Inactive"
3. Click "Activate" again

**Expected Results:**
- ✅ Status toggles correctly
- ✅ Badge updates

#### 2E: Delete Plan
**Steps:**
1. Click "Delete" on test plan
2. Confirm deletion

**Expected Results:**
- ✅ Plan removed from list
- ✅ Success message shown

---

### Test 3: Addons Management

#### 3A: View Addons
**Steps:**
1. Click "Addons" in sidebar
2. Verify addons are listed

**Expected Results:**
- ✅ 12 default addons visible
- ✅ Each shows icon, name, description
- ✅ Status badges correct

#### 3B: Create New Addon
**Steps:**
1. Click "Add New Addon"
2. Fill form:
   - Name: "Test Feature"
   - Slug: "test-feature"
   - Icon: "fas fa-test"
   - Description: "Testing addon"
   - Sort Order: 99
   - Check "Active"
3. Submit

**Expected Results:**
- ✅ Addon created successfully
- ✅ Appears in list
- ✅ Icon displays correctly

#### 3C: Edit Addon
**Steps:**
1. Edit test addon
2. Change name to "Test Module"
3. Update

**Expected Results:**
- ✅ Name updated correctly

#### 3D: Delete Addon
**Steps:**
1. Delete test addon
2. Confirm

**Expected Results:**
- ✅ Addon removed

---

### Test 4: Station Management

#### 4A: View Stations
**Steps:**
1. Click "Stations" in sidebar
2. Verify station list loads

**Expected Results:**
- ✅ All stations displayed
- ✅ Subscription status shows
- ✅ Expiry dates visible
- ✅ Status badges correct

#### 4B: View Station Details
**Steps:**
1. Click "View" on any station
2. Check station details page

**Expected Results:**
- ✅ Station info displays
- ✅ Current subscription shown (if any)
- ✅ Enabled addons listed
- ✅ Subscription history table shows

#### 4C: Assign Subscription
**Steps:**
1. On station details page
2. Click "Assign New Subscription"
3. Select "Basic Plan"
4. Set start date to today
5. Submit

**Expected Results:**
- ✅ Success message shown
- ✅ Current subscription updated
- ✅ End date calculated correctly (30 days from start)
- ✅ Status shows "Active"

#### 4D: Manage Addons
**Steps:**
1. Click "Manage Addons"
2. Select 1 addon (Basic plan allows 1)
3. Try to select 2nd addon

**Expected Results:**
- ✅ Can select 1 addon
- ✅ Other addons become disabled when limit reached
- ✅ Counter shows "Selected: 1 / 1"

#### 4E: Save Addons
**Steps:**
1. Keep 1 addon selected
2. Click "Save Addons"

**Expected Results:**
- ✅ Success message
- ✅ Station details show enabled addon
- ✅ Enabled timestamp shows

#### 4F: Upgrade Subscription
**Steps:**
1. Return to station details
2. Assign "Standard Plan" (3 addons)
3. Go to Manage Addons
4. Select 3 addons
5. Save

**Expected Results:**
- ✅ Can now select 3 addons
- ✅ Counter shows "Selected: 3 / 3"
- ✅ All 3 addons saved successfully

#### 4G: Premium Plan (Unlimited)
**Steps:**
1. Assign "Premium Plan"
2. Manage Addons
3. Select all 12 addons

**Expected Results:**
- ✅ No addon limit enforced
- ✅ Counter shows "Selected: 12"
- ✅ All addons can be selected
- ✅ All save successfully

---

### Test 5: Middleware Testing

#### 5A: Subscription Middleware
**Setup:**
1. Create test route in `routes/web.php`:
```php
Route::middleware(['subscription'])->get('/test-subscription', function() {
    return 'Subscription valid!';
});
```

**Test Steps:**
1. Set session: `session(['petrol_set_id' => STATION_ID_WITH_ACTIVE_SUB]);`
2. Access `/test-subscription`

**Expected Results:**
- ✅ Page loads with "Subscription valid!"

**Test Steps 2:**
1. Set session to station with expired subscription
2. Access `/test-subscription`

**Expected Results:**
- ✅ Redirected to subscription expired page
- ✅ Error message shown

#### 5B: Addon Middleware
**Setup:**
1. Create test route:
```php
Route::middleware(['subscription', 'addon:inventory'])->get('/test-addon', function() {
    return 'Addon enabled!';
});
```

**Test Steps:**
1. Set session to station WITH inventory addon
2. Access `/test-addon`

**Expected Results:**
- ✅ Page loads with "Addon enabled!"

**Test Steps 2:**
1. Set session to station WITHOUT inventory addon
2. Access `/test-addon`

**Expected Results:**
- ✅ 403 Forbidden error
- ✅ Message: "This feature is not available in your current plan"

---

### Test 6: Service Testing

#### 6A: SubscriptionService
Create test route:
```php
Route::get('/test-service', function() {
    $service = app(\App\Services\SubscriptionService::class);
    $stationId = 1; // Use valid station ID
    
    return [
        'has_subscription' => $service->hasActiveSubscription($stationId),
        'subscription' => $service->getActiveSubscription($stationId),
        'has_inventory' => $service->hasAddon($stationId, 'inventory'),
        'enabled_addons' => $service->getEnabledAddons($stationId),
        'days_remaining' => $service->getDaysRemaining($stationId),
        'is_expiring_soon' => $service->isExpiringSoon($stationId),
    ];
});
```

**Expected Results:**
- ✅ Returns JSON with all subscription data
- ✅ All methods work correctly
- ✅ No errors

---

### Test 7: Expiry Testing

**Steps:**
1. Create subscription with end_date = yesterday
2. Access protected route
3. Check subscription status in database

**Expected Results:**
- ✅ Status auto-updates to "expired"
- ✅ Access blocked
- ✅ Error message shown

---

### Test 8: UI/UX Testing

#### 8A: Responsive Design
**Steps:**
1. Open super admin on mobile viewport
2. Test all pages

**Expected Results:**
- ✅ Layouts adapt to mobile
- ✅ Cards stack vertically
- ✅ Forms are usable
- ✅ Navigation works

#### 8B: Form Validation
**Steps:**
1. Try to create plan without required fields
2. Try to create addon without name

**Expected Results:**
- ✅ Validation errors show
- ✅ Error messages are clear
- ✅ Form doesn't submit

#### 8C: Auto-Slug Generation
**Steps:**
1. Create new plan/addon
2. Type name
3. Watch slug field

**Expected Results:**
- ✅ Slug auto-generates from name
- ✅ Spaces become dashes
- ✅ Converts to lowercase

---

### Test 9: Edge Cases

#### 9A: Concurrent Subscriptions
**Steps:**
1. Assign subscription to station
2. Immediately assign different subscription

**Expected Results:**
- ✅ First subscription cancelled
- ✅ New subscription becomes active
- ✅ No duplicate active subscriptions

#### 9B: Addon Limit Enforcement
**Steps:**
1. Station with Basic plan (1 addon)
2. Enable 1 addon via UI
3. Try to enable 2nd via database

**Expected Results:**
- ✅ UI prevents selecting 2nd
- ✅ Form validation blocks submission

#### 9C: Delete Plan with Active Subscriptions
**Steps:**
1. Create plan
2. Assign to station
3. Try to delete plan

**Expected Results:**
- ✅ Deletion blocked
- ✅ Error message: "Cannot delete plan with active subscriptions"

#### 9D: Delete Addon in Use
**Steps:**
1. Enable addon for station
2. Try to delete addon

**Expected Results:**
- ✅ Deletion blocked or error shown
- ✅ Graceful handling

---

### Test 10: Performance Testing

**Steps:**
1. Create 100+ stations (use seeder)
2. Assign subscriptions to all
3. Access stations list

**Expected Results:**
- ✅ Page loads within reasonable time
- ✅ No timeout errors
- ✅ Pagination works (if implemented)

---

## 🔍 Database Verification

After testing, verify database integrity:

```sql
-- Check plans
SELECT * FROM subscription_plans;

-- Check addons
SELECT * FROM addons;

-- Check station subscriptions
SELECT 
    ss.id,
    s.name as station_name,
    sp.name as plan_name,
    ss.start_date,
    ss.end_date,
    ss.status
FROM station_subscriptions ss
JOIN stations s ON ss.station_id = s.id
JOIN subscription_plans sp ON ss.subscription_plan_id = sp.id;

-- Check enabled addons
SELECT 
    sa.id,
    s.name as station_name,
    a.name as addon_name,
    sa.is_enabled,
    sa.enabled_at
FROM station_addons sa
JOIN stations s ON sa.station_id = s.id
JOIN addons a ON sa.addon_id = a.id
WHERE sa.is_enabled = 1;
```

---

## ✅ Final Checklist

- [ ] All super admin pages load without errors
- [ ] Can create/edit/delete plans
- [ ] Can create/edit/delete addons
- [ ] Can assign subscriptions to stations
- [ ] Can manage station addons
- [ ] Addon limits are enforced
- [ ] Subscription middleware works
- [ ] Addon middleware works
- [ ] Service methods return correct data
- [ ] Expired subscriptions block access
- [ ] UI is responsive
- [ ] Forms validate correctly
- [ ] Database relationships correct
- [ ] No console errors
- [ ] No PHP errors in logs

---

## 📝 Reporting Bugs

If you find issues during testing:

1. **Check error logs:**
   - `storage/logs/laravel.log`
   - Browser console

2. **Verify configuration:**
   ```bash
   php artisan subscription:check
   ```

3. **Clear caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

4. **Document the issue:**
   - Steps to reproduce
   - Expected vs actual behavior
   - Screenshots if applicable
   - Error messages

---

## 🎉 Success Criteria

Testing is complete when:
- ✅ All test scenarios pass
- ✅ No critical bugs found
- ✅ Database integrity maintained
- ✅ Performance is acceptable
- ✅ UI/UX is smooth
- ✅ Documentation is accurate

---

**Happy Testing! 🚀**
