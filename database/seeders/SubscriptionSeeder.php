<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptions = [
            [
                'name' => 'Monthly Plan',
                'duration_type' => 'months',
                'duration_value' => 1,
                'price' => 999.00,
                'discount_percentage' => 0,
                'description' => 'Perfect for trying out our services',
                'features' => [
                    'Access to all basic features',
                    'Email support',
                    'Monthly reports',
                    'Up to 100 transactions',
                    '24/7 customer support'
                ],
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 1
            ],
            [
                'name' => 'Quarterly Plan',
                'duration_type' => 'months',
                'duration_value' => 3,
                'price' => 2499.00,
                'discount_percentage' => 15,
                'description' => 'Save 15% with our quarterly plan',
                'features' => [
                    'All features from Monthly Plan',
                    'Priority email support',
                    'Quarterly reports and analytics',
                    'Up to 500 transactions',
                    'Advanced dashboard',
                    'API access'
                ],
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 2
            ],
            [
                'name' => 'Biannual Plan',
                'duration_type' => 'months',
                'duration_value' => 6,
                'price' => 4999.00,
                'discount_percentage' => 25,
                'description' => 'Best value! Save 25% with 6 months plan',
                'features' => [
                    'All features from Quarterly Plan',
                    'Priority phone support',
                    'Dedicated account manager',
                    'Up to 2000 transactions',
                    'Custom integrations',
                    'Bulk operations',
                    'White-label options'
                ],
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Yearly Plan',
                'duration_type' => 'years',
                'duration_value' => 1,
                'price' => 9999.00,
                'discount_percentage' => 35,
                'description' => 'Maximum savings! Save 35% annually',
                'features' => [
                    'All features from Biannual Plan',
                    'VIP support 24/7',
                    'Dedicated success manager',
                    'Unlimited transactions',
                    'Custom feature development',
                    'Advanced analytics and insights',
                    'Multi-user accounts',
                    'Free training sessions',
                    'Priority feature requests'
                ],
                'is_active' => true,
                'is_popular' => false,
                'sort_order' => 4
            ]
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }
    }
}

