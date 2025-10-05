<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Page;
use App\Models\Action;
use App\Models\RolePermission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrator with full access',
            'is_default' => false,
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'description' => 'Regular user with limited access',
            'is_default' => true,
        ]);

        // Create pages
        $dashboard = Page::create([
            'name' => 'Dashboard',
            'route_pattern' => 'dashboard',
            'description' => 'Main dashboard page',
        ]);

        $users = Page::create([
            'name' => 'User Management',
            'route_pattern' => 'admin.users.*',
            'description' => 'Manage users',
        ]);

        $profile = Page::create([
            'name' => 'Profile',
            'route_pattern' => 'profile.*',
            'description' => 'User profile management',
        ]);

        // Create actions
        $view = Action::create(['name' => 'View', 'slug' => 'view']);
        $create = Action::create(['name' => 'Create', 'slug' => 'create']);
        $edit = Action::create(['name' => 'Edit', 'slug' => 'edit']);
        $delete = Action::create(['name' => 'Delete', 'slug' => 'delete']);

        // Admin permissions - full access to everything with 'all' scope
        $adminPages = [$dashboard, $users, $profile];
        $adminActions = [$view, $create, $edit, $delete];

        foreach ($adminPages as $page) {
            foreach ($adminActions as $action) {
                RolePermission::create([
                    'role_id' => $adminRole->id,
                    'page_id' => $page->id,
                    'action_id' => $action->id,
                    'scope' => 'all',
                ]);
            }
        }

        // User permissions - limited access with 'self' scope
        // Dashboard - view only
        RolePermission::create([
            'role_id' => $userRole->id,
            'page_id' => $dashboard->id,
            'action_id' => $view->id,
            'scope' => 'self',
        ]);

        // Profile - view and edit their own profile
        RolePermission::create([
            'role_id' => $userRole->id,
            'page_id' => $profile->id,
            'action_id' => $view->id,
            'scope' => 'self',
        ]);

        RolePermission::create([
            'role_id' => $userRole->id,
            'page_id' => $profile->id,
            'action_id' => $edit->id,
            'scope' => 'self',
        ]);

        $this->command->info('Roles, Pages, Actions, and Permissions seeded successfully!');
    }
}
