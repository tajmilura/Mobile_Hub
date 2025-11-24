<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'description', 'price', 'discount_price',
        'discount_start', 'discount_end', 'stock', 'image', 'gallery', 'video',
        'ram', 'storage', 'processor', 'os', 'battery', 'charging', 'display',
        'resolution', 'camera', 'front_camera', 'network', 'sim', 'build', 'weight',
        'dimensions', 'colors', 'fingerprint', 'water_resistance', 'bluetooth',
        'wifi', 'usb', 'audio', 'sensors', 'release_date', 'is_featured',
        'is_new_arrival', 'is_hot_deal', 'warranty', 'tags', 'sku', 'barcode'
    ];

    protected $casts = [
        'gallery' => 'array',
        'colors' => 'array',
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_hot_deal' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

   public function video() {
    return $this->hasOne(ProductVideo::class);
}


    public function scopeNewArrivals($query)
    {
        return $query->where('is_new_arrival', true);
    }

    public function scopeHotDeals($query)
    {
        return $query->where('is_hot_deal', true);
    }

     public function scopeIsFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }





}
