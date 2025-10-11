<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'duration_type',
        'duration_value',
        'price',
        'discount_percentage',
        'final_price',
        'description',
        'features',
        'is_active',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'final_price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Automatically calculate final price before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($subscription) {
            $subscription->final_price = $subscription->price - ($subscription->price * $subscription->discount_percentage / 100);
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('duration_value');
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    // Accessors
    public function getDurationTextAttribute()
    {
        $text = $this->duration_value . ' ';
        
        switch ($this->duration_type) {
            case 'days':
                $text .= $this->duration_value == 1 ? 'Day' : 'Days';
                break;
            case 'months':
                $text .= $this->duration_value == 1 ? 'Month' : 'Months';
                break;
            case 'years':
                $text .= $this->duration_value == 1 ? 'Year' : 'Years';
                break;
        }
        
        return $text;
    }

    public function getDiscountAmountAttribute()
    {
        return $this->price * $this->discount_percentage / 100;
    }

    public function getSavingsAttribute()
    {
        return $this->discount_amount;
    }
}
