<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    //

    protected $fillable = [
        'user_id',
        'product_id',
        'category_id',
        'brand_id',
        'visitor_id',
    ];

     // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
