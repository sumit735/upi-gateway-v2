<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'reply_id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
    ];

    /**
     * Get the ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the reply
     */
    public function reply()
    {
        return $this->belongsTo(TicketReply::class, 'reply_id');
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Check if file is an image
     */
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if file is a video
     */
    public function isVideo()
    {
        return $this->file_type === 'video';
    }
}
