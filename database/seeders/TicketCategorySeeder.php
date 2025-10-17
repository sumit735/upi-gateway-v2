<?php

namespace Database\Seeders;

use App\Models\TicketCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technical Support',
                'description' => 'Issues related to technical problems, bugs, or system errors',
                'color' => '#f5222d',
                'is_active' => true,
            ],
            [
                'name' => 'Billing & Payments',
                'description' => 'Questions about invoices, payments, subscriptions, or refunds',
                'color' => '#52c41a',
                'is_active' => true,
            ],
            [
                'name' => 'Feature Request',
                'description' => 'Suggestions for new features or improvements',
                'color' => '#1890ff',
                'is_active' => true,
            ],
            [
                'name' => 'Account & Login',
                'description' => 'Issues with account access, password reset, or profile settings',
                'color' => '#722ed1',
                'is_active' => true,
            ],
            [
                'name' => 'General Inquiry',
                'description' => 'General questions or information requests',
                'color' => '#faad14',
                'is_active' => true,
            ],
            [
                'name' => 'Other',
                'description' => 'Other issues or questions not covered by other categories',
                'color' => '#8c8c8c',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            TicketCategory::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
