<?php

use App\Enums\PageEnum;
use App\Enums\ActionEnum;
use App\Enums\ScopeEnum;

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
