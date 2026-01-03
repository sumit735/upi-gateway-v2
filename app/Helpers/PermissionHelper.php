<?php

use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;
use App\Models\User;
use App\Models\RolePermission;

if (!function_exists('permission')) {
    /**
     * Generate permission middleware string from enums
     *
     * @param PageEnum $page
     * @param ActionEnum $action
     * @param ScopeEnum|null $scope
     * @return string
     */
    function permission(
        PageEnum $page,
        ActionEnum $action,
        ?ScopeEnum $scope = null
    ): string {
        $scope = $scope ?? ScopeEnum::SELF;
        return "permission:{$page->value},{$action->value},{$scope->value}";
    }
}

if (!function_exists('can_page')) {
    /**
     * Check if current user has permission for a page and action
     *
     * @param PageEnum $page
     * @param ActionEnum $action
     * @param ScopeEnum|null $scope
     * @return bool
     */
    function can_page(
        PageEnum $page,
        ActionEnum $action,
        ?ScopeEnum $scope = null
    ): bool {
        $scope = $scope ?? ScopeEnum::SELF;
        return auth()->check() && auth()->user()->hasPermission(
            $page->value,
            $action->value,
            $scope->value
        );
    }
}

if (!function_exists('is_role')) {
    /**
     * Check if current user has a specific role
     *
     * @param App\Enums\RoleEnum $role
     * @return bool
     */
    function is_role($role): bool
    {
        return auth()->check() && auth()->user()->hasRole($role->value);
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission(User $user, PageEnum $page, ActionEnum $action, ScopeEnum $scope = ScopeEnum::SELF): bool
    {
        return $user->hasPermission($page->value, $action->value, $scope->value);
    }
}

if (!function_exists('getPageActions')) {
    /**
     * Get all available actions for a specific page
     */
    function getPageActions(PageEnum $page): array
    {
        return $page->availableActions();
    }
}

if (!function_exists('getUserPermissionsByPage')) {
    /**
     * Get user's permissions grouped by page
     */
    function getUserPermissionsByPage(User $user): array
    {
        $permissions = [];
        
        foreach (PageEnum::cases() as $page) {
            $pagePermissions = $user->role->permissions()
                ->whereHas('page', fn($q) => $q->where('route_pattern', $page->value))
                ->with(['action', 'page'])
                ->get();
            
            if ($pagePermissions->count() > 0) {
                $permissions[$page->value] = [
                    'page' => $page,
                    'permissions' => $pagePermissions,
                    'actions' => $pagePermissions->pluck('action.slug')->unique()->values()->toArray()
                ];
            }
        }
        
        return $permissions;
    }
}

if (!function_exists('canAccessPage')) {
    /**
     * Check if user can perform any action on a page
     */
    function canAccessPage(User $user, PageEnum $page): bool
    {
        return $user->role->permissions()
            ->whereHas('page', fn($q) => $q->where('route_pattern', $page->value))
            ->exists();
    }
}

if (!function_exists('getPermissionSummary')) {
    /**
     * Get user's permission summary
     */
    function getPermissionSummary(User $user): array
    {
        $summary = [
            'total_permissions' => $user->role->permissions()->count(),
            'pages_accessible' => 0,
            'global_actions' => [],
            'page_specific_actions' => [],
        ];

        foreach (PageEnum::cases() as $page) {
            if (canAccessPage($user, $page)) {
                $summary['pages_accessible']++;
                
                $pageActions = $user->role->permissions()
                    ->whereHas('page', fn($q) => $q->where('route_pattern', $page->value))
                    ->with('action')
                    ->get()
                    ->pluck('action')
                    ->unique('value');

                foreach ($pageActions as $action) {
                    if ($action && ActionEnum::tryFrom($action->slug)) {
                        $actionEnum = ActionEnum::from($action->slug);
                        if ($actionEnum->isGlobal()) {
                            if (!in_array($actionEnum->value, $summary['global_actions'])) {
                                $summary['global_actions'][] = $actionEnum->value;
                            }
                        } else {
                            $summary['page_specific_actions'][] = [
                                'page' => $page->label(),
                                'action' => $actionEnum->label(),
                                'category' => $actionEnum->category()
                            ];
                        }
                    }
                }
            }
        }

        return $summary;
    }
}

if (!function_exists('middleware')) {
    /**
     * Generate permission middleware string for routes
     */
    function middleware(PageEnum $page, ActionEnum $action, ScopeEnum $scope = ScopeEnum::SELF): string
    {
        return "permission:{$page->value},{$action->value},{$scope->value}";
    }
}
