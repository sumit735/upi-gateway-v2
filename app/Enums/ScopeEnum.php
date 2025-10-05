<?php

namespace App\Enums;

enum ScopeEnum: string
{
    case SELF = 'self';
    case ALL = 'all';
    
    /**
     * Get the display name for the scope
     */
    public function label(): string
    {
        return match($this) {
            self::SELF => 'Own Resources Only',
            self::ALL => 'All Resources',
        };
    }

    /**
     * Get all scopes as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all scopes with labels
     */
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
