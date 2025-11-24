<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'product_name',
        'product_sku',
        'product_description',
        'product_image',
        'product_price',
        'sale_price',
        'quantity',
        'subtotal',
        'tax',
        'discount',
        'total',
        'variant',
        'size',
        'color',
        'variant_attributes',
        'status',
        'is_digital',
        'download_link',
        'license_key'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'variant_attributes' => 'array',
        'is_digital' => 'boolean',
        'returned_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper Methods
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total, 2);
    }

    public function getVariantDetailsAttribute()
    {
        if ($this->variant_attributes) {
            return implode(', ', array_values($this->variant_attributes));
        }

        return $this->variant;
    }
}
