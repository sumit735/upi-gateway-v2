<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'page_id',
        'action_id',
        'scope',
    ];

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
