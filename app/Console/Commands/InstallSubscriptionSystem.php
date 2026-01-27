<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallSubscriptionSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Subscription & Addon Management System';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Installing Subscription & Addon Management System...');
        $this->newLine();

        // Step 1: Run migrations
        $this->info('📊 Running database migrations...');
        $this->call('migrate', ['--path' => 'database/migrations']);
        $this->newLine();

        // Step 2: Seed subscription plans
        $this->info('📦 Seeding subscription plans...');
        $this->call('db:seed', ['--class' => 'SubscriptionPlanSeeder']);
        $this->newLine();

        // Step 3: Seed addons
        $this->info('🧩 Seeding addons...');
        $this->call('db:seed', ['--class' => 'AddonSeeder']);
        $this->newLine();

        // Display success message
        $this->newLine();
        $this->info('✅ Subscription System installed successfully!');
        $this->newLine();

        // Display next steps
        $this->comment('📝 Next Steps:');
        $this->line('1. Register SubscriptionServiceProvider in config/app.php or bootstrap/providers.php');
        $this->line('2. Add middleware aliases in app/Http/Kernel.php:');
        $this->line('   - subscription => CheckSubscription::class');
        $this->line('   - addon => CheckAddon::class');
        $this->line('3. Access Super Admin Panel at: /super-admin/dashboard');
        $this->newLine();

        // Display created plans
        $this->comment('📋 Created Subscription Plans:');
        $plans = \App\Models\SubscriptionPlan::all();
        foreach ($plans as $plan) {
            $this->line("   • {$plan->name} - \${$plan->price} ({$plan->duration_days} days, " . 
                       ($plan->max_addons == -1 ? 'Unlimited' : $plan->max_addons) . " addons)");
        }
        $this->newLine();

        // Display created addons
        $this->comment('🧩 Created Addons:');
        $addons = \App\Models\Addon::orderBy('sort_order')->get();
        foreach ($addons as $addon) {
            $this->line("   • {$addon->name}");
        }
        $this->newLine();

        $this->info('🎉 Installation complete! Happy coding!');
        
        return Command::SUCCESS;
    }
}
