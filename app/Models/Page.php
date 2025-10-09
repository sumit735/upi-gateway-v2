<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'route_pattern',
        'description',
    ];

    // Relationships
    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
                    ->withPivot('action_id', 'scope')
                    ->withTimestamps();
    }
}
