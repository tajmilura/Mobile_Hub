<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'color',
        'size',
        'variant',
        'price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Fix: Ensure relationship is correct
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Add accessor for subtotal
    public function getSubtotalAttribute()
    {
        if ($this->product && $this->product->price) {
            return $this->product->price * $this->quantity;
        }
        return 0;
    }
}
