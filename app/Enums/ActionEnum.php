<?php

namespace App\Enums;

enum ActionEnum: string
{
    // Global actions - available for all pages
    case VIEW = 'view';
    case CREATE = 'create';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case EXPORT = 'export';
    
    // Page-specific actions
    case APPROVE = 'approve';
    case REJECT = 'reject';
    case SUSPEND = 'suspend';
    case ACTIVATE = 'activate';
    case RECONCILE = 'reconcile';
    case GENERATE_REPORT = 'generate_report';
    case SEND_NOTIFICATION = 'send_notification';
    
    // Ticket-specific actions
    case ASSIGN = 'assign';
    case CHANGE_STATUS = 'change_status';
    case CHANGE_PRIORITY = 'change_priority';
    case REPLY = 'reply';
    
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
            self::EXPORT => 'Export',
            self::APPROVE => 'Approve',
            self::REJECT => 'Reject',
            self::SUSPEND => 'Suspend',
            self::ACTIVATE => 'Activate',
            self::RECONCILE => 'Reconcile',
            self::GENERATE_REPORT => 'Generate Report',
            self::SEND_NOTIFICATION => 'Send Notification',
            self::ASSIGN => 'Assign',
            self::CHANGE_STATUS => 'Change Status',
            self::CHANGE_PRIORITY => 'Change Priority',
            self::REPLY => 'Reply',
        };
    }
    
    /**
     * Check if this action is global (available for all pages)
     */
    public function isGlobal(): bool
    {
        return in_array($this, [
            self::VIEW,
            self::CREATE,
            self::EDIT,
            self::DELETE,
            self::EXPORT,
        ]);
    }
    
    /**
     * Get the category of the action
     */
    public function category(): string
    {
        return match($this) {
            self::VIEW, self::CREATE, self::EDIT, self::DELETE, self::EXPORT => 'Global',
            self::APPROVE, self::REJECT => 'Approval',
            self::SUSPEND, self::ACTIVATE => 'Status Management',
            self::RECONCILE => 'Financial',
            self::GENERATE_REPORT => 'Reporting',
            self::SEND_NOTIFICATION => 'Communication',
            self::ASSIGN, self::CHANGE_STATUS, self::CHANGE_PRIORITY, self::REPLY => 'Ticket Management',
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
    
    /**
     * Get only global actions
     */
    public static function globalActions(): array
    {
        return collect(self::cases())
            ->filter(fn($case) => $case->isGlobal())
            ->values()
            ->toArray();
    }
    
    /**
     * Get actions by category
     */
    public static function byCategory(): array
    {
        return collect(self::cases())
            ->groupBy(fn($case) => $case->category())
            ->map(fn($actions) => $actions->values())
            ->toArray();
    }
}
