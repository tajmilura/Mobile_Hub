<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'code', 
        'description',
        'config',
        'is_active',
        'is_online',
        'charge',
        'sort_order'
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'is_online' => 'boolean',
        'charge' => 'decimal:2'
    ];

    //  Scope method 
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    //  Additional useful scopes
    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    public function scopeOffline($query)
    {
        return $query->where('is_online', false);
    }

    public function scopeBySortOrder($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Methods
    public function calculateCharge($amount)
    {
        if ($this->charge > 0) {
            return ($amount * $this->charge) / 100;
        }
        return 0;
    }
}
