<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Page;
use App\Models\Action;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\Settings;

class CompleteDataSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create Roles
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Administrator role with full access', 'is_default' => false]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'User'],
            ['description' => 'Regular user role', 'is_default' => true]
        );

        // Create Pages if they don't exist
        $pagesList = [
            ['route_pattern' => 'dashboard', 'name' => 'Dashboard', 'description' => 'Main dashboard page'],
            ['route_pattern' => 'admin.users.*', 'name' => 'User Management', 'description' => 'Manage users'],
            ['route_pattern' => 'profile.*', 'name' => 'Profile', 'description' => 'User profile management'],
            ['route_pattern' => 'admin.transactions.*', 'name' => 'Transactions', 'description' => 'Transaction management'],
            ['route_pattern' => 'admin.payments.*', 'name' => 'Payments', 'description' => 'Payment management'],
            ['route_pattern' => 'admin.reports.*', 'name' => 'Reports', 'description' => 'Reporting system'],
            ['route_pattern' => 'admin.settings.*', 'name' => 'Settings', 'description' => 'Application settings'],
            ['route_pattern' => 'admin.chat.*', 'name' => 'Chat', 'description' => 'Real-time messaging'],
        ];

        foreach ($pagesList as $pageData) {
            Page::firstOrCreate(
                ['route_pattern' => $pageData['route_pattern']],
                ['name' => $pageData['name'], 'description' => $pageData['description']]
            );
        }

        // Create Actions
        if (Action::count() === 0) {
            $actions = [
                ['slug' => 'view', 'name' => 'View'],
                ['slug' => 'create', 'name' => 'Create'],
                ['slug' => 'edit', 'name' => 'Edit'],
                ['slug' => 'delete', 'name' => 'Delete'],
                ['slug' => 'export', 'name' => 'Export'],
            ];

            foreach ($actions as $actionData) {
                Action::create($actionData);
            }
        }

        // Create Role Permissions if they don't exist
        if (RolePermission::count() === 0) {
            $allPages = Page::all();
            $allActions = Action::all();

            foreach ($allPages as $page) {
                foreach ($allActions as $action) {
                    RolePermission::create([
                        'role_id' => $adminRole->id,
                        'page_id' => $page->id,
                        'action_id' => $action->id,
                        'scope' => 'all',
                    ]);
                }
            }

            // User permissions
            $dashboardPage = Page::where('route_pattern', 'dashboard')->first();
            $profilePage = Page::where('route_pattern', 'profile.*')->first();
            $chatPage = Page::where('route_pattern', 'admin.chat.*')->first();
            
            $viewAction = Action::where('slug', 'view')->first();
            $editAction = Action::where('slug', 'edit')->first();

            if ($dashboardPage && $viewAction) {
                RolePermission::create([
                    'role_id' => $userRole->id,
                    'page_id' => $dashboardPage->id,
                    'action_id' => $viewAction->id,
                    'scope' => 'self',
                ]);
            }

            if ($profilePage) {
                if ($viewAction) {
                    RolePermission::create([
                        'role_id' => $userRole->id,
                        'page_id' => $profilePage->id,
                        'action_id' => $viewAction->id,
                        'scope' => 'self',
                    ]);
                }
                if ($editAction) {
                    RolePermission::create([
                        'role_id' => $userRole->id,
                        'page_id' => $profilePage->id,
                        'action_id' => $editAction->id,
                        'scope' => 'self',
                    ]);
                }
            }

            if ($chatPage && $viewAction) {
                RolePermission::create([
                    'role_id' => $userRole->id,
                    'page_id' => $chatPage->id,
                    'action_id' => $viewAction->id,
                    'scope' => 'self',
                ]);
            }
        }

        // Create Users if they don't exist
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'phone' => '9876543210',
                'aadhaar' => '123456789012',
                'pancard' => 'ABCDE1234F',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_active' => true,
                'is_blocked' => false,
            ]);

            User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'phone' => '9876543211',
                'aadhaar' => '123456789013',
                'pancard' => 'ABCDE1234G',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'is_active' => true,
                'is_blocked' => false,
            ]);

            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '9876543212',
                'aadhaar' => '123456789014',
                'pancard' => 'ABCDE1234H',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
                'is_active' => true,
                'is_blocked' => false,
            ]);
        }

        // Create Settings if they don't exist
        if (Settings::count() === 0) {
            $settings = [
                ['key' => 'app_name', 'category' => 'web_config', 'value' => 'UPI Gateway', 'description' => 'Application name'],
                ['key' => 'logo', 'category' => 'web_config', 'value' => 'logo.png', 'description' => 'Website logo filename'],
                ['key' => 'favicon', 'category' => 'web_config', 'value' => 'favicon.ico', 'description' => 'Website favicon filename'],
                ['key' => 'upi_merchant_id', 'category' => 'pg_config', 'value' => '', 'description' => 'UPI Merchant ID'],
                ['key' => 'upi_api_key', 'category' => 'pg_config', 'value' => '', 'description' => 'UPI API Key'],
                ['key' => 'transaction_fee_percentage', 'category' => 'rates', 'value' => '2.5', 'description' => 'Transaction fee percentage'],
            ];

            foreach ($settings as $setting) {
                Settings::create($setting);
            }
        }

        $this->command->info('✓ Database seeded successfully!');
        $this->command->info('✓ Admin: admin@example.com / password');
        $this->command->info('✓ User: user@example.com / password');
        $this->command->info('✓ User: john@example.com / password');
    }
}
