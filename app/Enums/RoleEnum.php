<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    
    /**
     * Get the display name for the role
     */
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::USER => 'User',
        };
    }

    /**
     * Get the description for the role
     */
    public function description(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator with full access',
            self::USER => 'Regular user with limited access',
        };
    }

    /**
     * Check if this is the default role
     */
    public function isDefault(): bool
    {
        return $this === self::USER;
    }

    /**
     * Get all roles as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all roles with labels
     */
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
