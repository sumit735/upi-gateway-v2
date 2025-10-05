<?php

namespace App\Enums;

enum PageEnum: string
{
    case DASHBOARD = 'dashboard';
    case USER_MANAGEMENT = 'admin.users.*';
    case PROFILE = 'profile.*';
    
    /**
     * Get the display name for the page
     */
    public function label(): string
    {
        return match($this) {
            self::DASHBOARD => 'Dashboard',
            self::USER_MANAGEMENT => 'User Management',
            self::PROFILE => 'Profile',
        };
    }

    /**
     * Get the description for the page
     */
    public function description(): string
    {
        return match($this) {
            self::DASHBOARD => 'Main dashboard page',
            self::USER_MANAGEMENT => 'Manage users',
            self::PROFILE => 'User profile management',
        };
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
