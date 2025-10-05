<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Page;
use App\Models\Action;
use App\Models\RolePermission;
use App\Enums\RoleEnum;
use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles using enum
        $adminRole = Role::create([
            'name' => RoleEnum::ADMIN->value,
            'description' => RoleEnum::ADMIN->description(),
            'is_default' => RoleEnum::ADMIN->isDefault(),
        ]);

        $userRole = Role::create([
            'name' => RoleEnum::USER->value,
            'description' => RoleEnum::USER->description(),
            'is_default' => RoleEnum::USER->isDefault(),
        ]);

        // Create pages using enum
        $dashboard = Page::create([
            'name' => PageEnum::DASHBOARD->label(),
            'route_pattern' => PageEnum::DASHBOARD->value,
            'description' => PageEnum::DASHBOARD->description(),
        ]);

        $users = Page::create([
            'name' => PageEnum::USER_MANAGEMENT->label(),
            'route_pattern' => PageEnum::USER_MANAGEMENT->value,
            'description' => PageEnum::USER_MANAGEMENT->description(),
        ]);

        $profile = Page::create([
            'name' => PageEnum::PROFILE->label(),
            'route_pattern' => PageEnum::PROFILE->value,
            'description' => PageEnum::PROFILE->description(),
        ]);

        // Create actions using enum
        $view = Action::create([
            'name' => ActionEnum::VIEW->label(),
            'slug' => ActionEnum::VIEW->value
        ]);
        
        $create = Action::create([
            'name' => ActionEnum::CREATE->label(),
            'slug' => ActionEnum::CREATE->value
        ]);
        
        $edit = Action::create([
            'name' => ActionEnum::EDIT->label(),
            'slug' => ActionEnum::EDIT->value
        ]);
        
        $delete = Action::create([
            'name' => ActionEnum::DELETE->label(),
            'slug' => ActionEnum::DELETE->value
        ]);

        // Admin permissions - full access to everything with 'all' scope
        $adminPages = [$dashboard, $users, $profile];
        $adminActions = [$view, $create, $edit, $delete];

        foreach ($adminPages as $page) {
            foreach ($adminActions as $action) {
                RolePermission::create([
                    'role_id' => $adminRole->id,
                    'page_id' => $page->id,
                    'action_id' => $action->id,
                    'scope' => ScopeEnum::ALL->value,
                ]);
            }
        }

        // User permissions - limited access with 'self' scope
        // Dashboard - view only
        RolePermission::create([
            'role_id' => $userRole->id,
            'page_id' => $dashboard->id,
            'action_id' => $view->id,
            'scope' => ScopeEnum::SELF->value,
        ]);

        // Profile - view and edit their own profile
        RolePermission::create([
            'role_id' => $userRole->id,
            'page_id' => $profile->id,
            'action_id' => $view->id,
            'scope' => ScopeEnum::SELF->value,
        ]);

        RolePermission::create([
            'role_id' => $userRole->id,
            'page_id' => $profile->id,
            'action_id' => $edit->id,
            'scope' => ScopeEnum::SELF->value,
        ]);

        $this->command->info('Roles, Pages, Actions, and Permissions seeded successfully!');
    }
}
