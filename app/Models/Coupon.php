<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type', // 'fixed' or 'percentage'
        'discount_amount',
        'discount_percent',
        'minimum_amount',
        'valid_from',
        'valid_until',
        'usage_limit',
        'usage_count',
        'is_active',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = now()->toDateString();
        return $query->where(function($q) use ($now) {
            $q->whereNull('valid_from')
              ->orWhere('valid_from', '<=', $now);
        })->where(function($q) use ($now) {
            $q->whereNull('valid_until')
              ->orWhere('valid_until', '>=', $now);
        });
    }

    public function scopeAvailable($query)
    {
        return $query->where(function($q) {
            $q->whereNull('usage_limit')
              ->orWhereColumn('usage_count', '<', 'usage_limit');
        });
    }

    // Helper methods
    public function isValid()
    {
        $now = now()->toDateString();
        
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check date validity
        if ($this->valid_from && $this->valid_from->toDateString() > $now) {
            return false;
        }

        if ($this->valid_until && $this->valid_until->toDateString() < $now) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeUsed($orderTotal = 0)
    {
        if (!$this->isValid()) {
            return false;
        }

        // Check minimum amount
        if ($this->minimum_amount && floatval($orderTotal) < floatval($this->minimum_amount)) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if (!$this->canBeUsed($orderTotal)) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return min(($orderTotal * $this->discount_percent / 100), $orderTotal);
        } else {
            return min($this->discount_amount, $orderTotal);
        }
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    public function getDiscountDisplayAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_percent . '%';
        } else {
            return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
        }
    }
}
