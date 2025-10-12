<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactorRecoveryCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'used',
        'used_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'used_at' => 'datetime',
    ];

    /**
     * Get the user that owns the recovery code.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark this recovery code as used.
     */
    public function markAsUsed()
    {
        $this->update([
            'used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Scope to get only unused codes.
     */
    public function scopeUnused($query)
    {
        return $query->where('used', false);
    }
}
