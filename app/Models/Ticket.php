<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'subject',
        'description',
        'priority',
        'status',
        'name',
        'email',
        'assigned_to',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = self::generateTicketNumber();
            }
        });
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber()
    {
        $year = date('Y');
        $lastTicket = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $lastTicket ? intval(substr($lastTicket->ticket_number, -4)) + 1 : 1;
        
        return 'TKT-' . $year . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    /**
     * Get the user who created the ticket
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin assigned to resolve
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all attachments
     */
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    /**
     * Get all replies
     */
    public function replies()
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * Scope for open tickets
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope for resolved tickets
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Check if ticket is open
     */
    public function isOpen()
    {
        return in_array($this->status, ['open', 'in_progress']);
    }

    /**
     * Get the creator name (user or guest)
     */
    public function getCreatorNameAttribute()
    {
        return $this->user ? $this->user->name : $this->name;
    }

    /**
     * Get the creator email
     */
    public function getCreatorEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->email;
    }
}
