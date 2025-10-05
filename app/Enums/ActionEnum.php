<?php

namespace App\Enums;

enum ActionEnum: string
{
    case VIEW = 'view';
    case CREATE = 'create';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case APPROVE = 'approve';
    case REJECT = 'reject';
    case EXPORT = 'export';
    
    /**
     * Get the display name for the action
     */
    public function label(): string
    {
        return match($this) {
            self::VIEW => 'View',
            self::CREATE => 'Create',
            self::EDIT => 'Edit',
            self::DELETE => 'Delete',
            self::APPROVE => 'Approve',
            self::REJECT => 'Reject',
            self::EXPORT => 'Export',
        };
    }

    /**
     * Get all actions as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all actions with labels
     */
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
