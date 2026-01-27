<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckSubscriptionSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the Subscription System is properly configured';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking Subscription System Configuration...');
        $this->newLine();

        $allPassed = true;

        // Check 1: Migrations
        $this->info('1. Checking Database Migrations...');
        $tables = ['subscription_plans', 'addons', 'station_subscriptions', 'station_addons'];
        foreach ($tables as $table) {
            if (\Schema::hasTable($table)) {
                $this->line("   ✅ Table '{$table}' exists");
            } else {
                $this->error("   ❌ Table '{$table}' not found");
                $allPassed = false;
            }
        }
        $this->newLine();

        // Check 2: Service Provider
        $this->info('2. Checking Service Provider Registration...');
        $providers = config('app.providers', []);
        if (in_array(\App\Providers\SubscriptionServiceProvider::class, $providers)) {
            $this->line("   ✅ SubscriptionServiceProvider is registered");
        } else {
            $this->error("   ❌ SubscriptionServiceProvider not found in config/app.php");
            $this->warn("   ℹ️  Add to config/app.php or bootstrap/providers.php");
            $allPassed = false;
        }
        $this->newLine();

        // Check 3: Middleware
        $this->info('3. Checking Middleware Registration...');
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        $middlewareAliases = (new \ReflectionClass($kernel))->getProperty('middlewareAliases');
        $middlewareAliases->setAccessible(true);
        $aliases = $middlewareAliases->getValue($kernel);
        
        if (isset($aliases['subscription'])) {
            $this->line("   ✅ 'subscription' middleware registered");
        } else {
            $this->error("   ❌ 'subscription' middleware not registered");
            $this->warn("   ℹ️  Add to app/Http/Kernel.php");
            $allPassed = false;
        }

        if (isset($aliases['addon'])) {
            $this->line("   ✅ 'addon' middleware registered");
        } else {
            $this->error("   ❌ 'addon' middleware not registered");
            $this->warn("   ℹ️  Add to app/Http/Kernel.php");
            $allPassed = false;
        }
        $this->newLine();

        // Check 4: Seeded Data
        $this->info('4. Checking Seeded Data...');
        $planCount = \App\Models\SubscriptionPlan::count();
        $addonCount = \App\Models\Addon::count();

        if ($planCount > 0) {
            $this->line("   ✅ Found {$planCount} subscription plan(s)");
        } else {
            $this->error("   ❌ No subscription plans found");
            $this->warn("   ℹ️  Run: php artisan db:seed --class=SubscriptionPlanSeeder");
            $allPassed = false;
        }

        if ($addonCount > 0) {
            $this->line("   ✅ Found {$addonCount} addon(s)");
        } else {
            $this->error("   ❌ No addons found");
            $this->warn("   ℹ️  Run: php artisan db:seed --class=AddonSeeder");
            $allPassed = false;
        }
        $this->newLine();

        // Check 5: Routes
        $this->info('5. Checking Routes...');
        $routes = \Route::getRoutes();
        $requiredRoutes = [
            'super-admin.dashboard',
            'super-admin.plans.index',
            'super-admin.addons.index',
            'super-admin.stations.index',
        ];

        foreach ($requiredRoutes as $routeName) {
            if ($routes->hasNamedRoute($routeName)) {
                $this->line("   ✅ Route '{$routeName}' exists");
            } else {
                $this->error("   ❌ Route '{$routeName}' not found");
                $allPassed = false;
            }
        }
        $this->newLine();

        // Check 6: Views
        $this->info('6. Checking Views...');
        $views = [
            'super-admin.pages.dashboard',
            'super-admin.pages.subscription-plans.index',
            'super-admin.pages.addons.index',
            'super-admin.pages.stations.index',
        ];

        foreach ($views as $view) {
            if (view()->exists($view)) {
                $this->line("   ✅ View '{$view}' exists");
            } else {
                $this->error("   ❌ View '{$view}' not found");
                $allPassed = false;
            }
        }
        $this->newLine();

        // Final Summary
        $this->newLine();
        if ($allPassed) {
            $this->info('✅ All checks passed! Subscription System is properly configured.');
            $this->newLine();
            $this->comment('🚀 You can now access the Super Admin Panel at:');
            $this->line('   ' . url('/super-admin/dashboard'));
        } else {
            $this->error('❌ Some checks failed. Please review the errors above.');
            $this->newLine();
            $this->comment('📖 For help, check:');
            $this->line('   - QUICK_SETUP_GUIDE.md');
            $this->line('   - SUBSCRIPTION_SYSTEM_README.md');
        }
        $this->newLine();

        return $allPassed ? Command::SUCCESS : Command::FAILURE;
    }
}
