<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'description' => '7-day free trial with no addons. Perfect for testing the system.',
                'price' => 0.00,
                'duration_days' => 7,
                'max_addons' => 0,
                'is_trial' => true,
                'is_active' => true,
                'features' => json_encode([
                    'Basic Features',
                    'Limited Support',
                    'No Addons',
                    '7 Days Duration'
                ]),
            ],
            [
                'name' => 'Basic Plan',
                'slug' => 'basic-plan',
                'description' => 'Starter plan with 1 addon. Great for small petrol stations.',
                'price' => 49.99,
                'duration_days' => 30,
                'max_addons' => 1,
                'is_trial' => false,
                'is_active' => true,
                'features' => json_encode([
                    'All Basic Features',
                    '1 Addon Included',
                    'Email Support',
                    'Monthly Billing'
                ]),
            ],
            [
                'name' => 'Standard Plan',
                'slug' => 'standard-plan',
                'description' => 'Most popular plan with 3 addons. Perfect for growing businesses.',
                'price' => 99.99,
                'duration_days' => 30,
                'max_addons' => 3,
                'is_trial' => false,
                'is_active' => true,
                'features' => json_encode([
                    'All Basic Features',
                    '3 Addons Included',
                    'Priority Support',
                    'Advanced Reporting',
                    'Monthly Billing'
                ]),
            ],
            [
                'name' => 'Premium Plan',
                'slug' => 'premium-plan',
                'description' => 'Enterprise plan with unlimited addons. Best for large operations.',
                'price' => 199.99,
                'duration_days' => 30,
                'max_addons' => -1, // Unlimited
                'is_trial' => false,
                'is_active' => true,
                'features' => json_encode([
                    'All Advanced Features',
                    'Unlimited Addons',
                    '24/7 Premium Support',
                    'Custom Integrations',
                    'Dedicated Account Manager',
                    'Monthly Billing'
                ]),
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }

        $this->command->info('Subscription plans seeded successfully!');
    }
}
