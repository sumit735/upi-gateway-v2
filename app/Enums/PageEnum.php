<?php

namespace App\Enums;

enum PageEnum: string
{
    case DASHBOARD = 'dashboard';
    case USER_MANAGEMENT = 'admin.users.*';
    case PROFILE = 'profile.*';
    case TRANSACTIONS = 'admin.transactions.*';
    case PAYMENTS = 'admin.payments.*';
    case REPORTS = 'admin.reports.*';
    case SETTINGS = 'admin.settings.*';
    case DEV_TOOLS = 'portal.dev.*';
    case SUBSCRIPTIONS = 'admin.settings.subscriptions.*';
    
    /**
     * Get the display name for the page
     */
    public function label(): string
    {
        return match($this) {
            self::DASHBOARD => 'Dashboard',
            self::USER_MANAGEMENT => 'User Management',
            self::PROFILE => 'Profile',
            self::TRANSACTIONS => 'Transactions',
            self::PAYMENTS => 'Payments',
            self::REPORTS => 'Reports',
            self::SETTINGS => 'Settings',
            self::DEV_TOOLS => 'Developer Tools',
            self::SUBSCRIPTIONS => 'Subscriptions',
        };
    }

    /**
     * Get the description for the page
     */
    public function description(): string
    {
        return match($this) {
            self::DASHBOARD => 'Main dashboard page',
            self::USER_MANAGEMENT => 'Manage users and their roles',
            self::PROFILE => 'User profile management',
            self::TRANSACTIONS => 'View and manage transactions',
            self::PAYMENTS => 'Process and manage payments',
            self::REPORTS => 'Generate and view reports',
            self::SETTINGS => 'Application configuration',
            self::DEV_TOOLS => 'Developer tools and utilities',
            self::SUBSCRIPTIONS => 'Manage user subscriptions',
        };
    }
    
    /**
     * Get available actions for this page
     */
    public function availableActions(): array
    {
        // Start with global actions
        $globalActions = ActionEnum::globalActions();
        
        // Add page-specific actions
        $pageSpecificActions = match($this) {
            self::DASHBOARD => [
                // Only view and export for dashboard
            ],
            self::USER_MANAGEMENT => [
                ActionEnum::SUSPEND,
                ActionEnum::ACTIVATE,
                ActionEnum::SEND_NOTIFICATION,
            ],
            self::PROFILE => [
                // Only global actions for profile
            ],
            self::TRANSACTIONS => [
                ActionEnum::APPROVE,
                ActionEnum::REJECT,
                ActionEnum::RECONCILE,
            ],
            self::PAYMENTS => [
                ActionEnum::APPROVE,
                ActionEnum::REJECT,
                ActionEnum::RECONCILE,
            ],
            self::REPORTS => [
                ActionEnum::GENERATE_REPORT,
            ],
            self::SETTINGS => [
                // Only global actions for settings
            ],
            self::DEV_TOOLS => [
                // Only global actions for dev tools
            ],
            self::SUBSCRIPTIONS => [
                // Only global actions for subscriptions
            ],
        };
        
        return array_merge($globalActions, $pageSpecificActions);
    }
    
    /**
     * Get actions grouped by category for this page
     */
    public function actionsByCategory(): array
    {
        $availableActions = $this->availableActions();
        
        return collect($availableActions)
            ->groupBy(fn($action) => $action->category())
            ->map(fn($actions) => $actions->values())
            ->toArray();
    }
    
    /**
     * Check if a specific action is available for this page
     */
    public function hasAction(ActionEnum $action): bool
    {
        return in_array($action, $this->availableActions());
    }

    /**
     * Get all pages as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all pages with labels
     */
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
