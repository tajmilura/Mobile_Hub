<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'description',
        'price',
        'discount_price',
        'stock',
        'image',
        'gallery',
        'ram',
        'storage',
        'processor',
        'os',
        'battery',
        'charging',
        'display',
        'resolution',
        'camera',
        'front_camera',
        'network',
        'sim',
        'build',
        'weight',
        'dimensions',
        'colors',
        'fingerprint',
        'water_resistance',
        'bluetooth',
        'wifi',
        'usb',
        'audio',
        'sensors',
        'release_date',
        'is_featured',
        'is_new_arrival',
        'is_hot_deal',
    ];

    // Casts for JSON / boolean fields
    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_hot_deal' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    // Relationships

    // Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Order Items (if needed)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
