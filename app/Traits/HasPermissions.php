<?php

namespace App\Traits;

use App\Models\RolePermission;

trait HasPermissions
{
    /**
     * Check if user has permission for a page and action
     *
     * @param string $routePattern
     * @param string $actionSlug
     * @param string $scope
     * @return bool
     */
    public function hasPermission(string $routePattern, string $actionSlug, string $scope = 'self'): bool
    {
        // Get permissions from session cache
        $permissions = session('user_permissions');
        
        if (!$permissions) {
            return false;
        }
        // Check if route pattern exists in permissions
        if (!isset($permissions[$routePattern])) {
            // Try wildcard matching (e.g., admin.users.* matches admin.users.index)
            foreach ($permissions as $pattern => $perms) {
                if ($this->matchRoutePattern($pattern, $routePattern)) {
                    return $this->checkActionPermission($perms, $actionSlug, $scope);
                }
            }
            return false;
        }

        return $this->checkActionPermission($permissions[$routePattern], $actionSlug, $scope);
    }

    /**
     * Check if action exists in permissions with proper scope
     *
     * @param array $permissions
     * @param string $actionSlug
     * @param string $scope
     * @return bool
     */
    protected function checkActionPermission(array $permissions, string $actionSlug, string $scope): bool
    {
        foreach ($permissions as $permission) {
            if ($permission['action_slug'] === $actionSlug) {
                // 'all' scope has access to both 'self' and 'all'
                if ($permission['scope'] === 'all') {
                    return true;
                }
                // 'self' scope only has access to 'self'
                if ($permission['scope'] === 'self' && $scope === 'self') {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * Match route pattern with wildcards
     *
     * @param string $pattern
     * @param string $route
     * @return bool
     */
    protected function matchRoutePattern(string $pattern, string $route): bool
    {
        // Convert wildcard pattern to regex
        $regex = str_replace(['*', '.'], ['.*', '\\.'], $pattern);
        return (bool) preg_match('/^' . $regex . '$/', $route);
    }

    /**
     * Check if user can perform action on their own resources
     *
     * @param string $routePattern
     * @param string $actionSlug
     * @return bool
     */
    public function canSelf(string $routePattern, string $actionSlug): bool
    {
        return $this->hasPermission($routePattern, $actionSlug, 'self');
    }

    /**
     * Check if user can perform action on all resources
     *
     * @param string $routePattern
     * @param string $actionSlug
     * @return bool
     */
    public function canAll(string $routePattern, string $actionSlug): bool
    {
        return $this->hasPermission($routePattern, $actionSlug, 'all');
    }

    /**
     * Get user's role
     *
     * @return \App\Models\Role|null
     */
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    /**
     * Check if user has a specific role
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
