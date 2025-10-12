<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'brand_icon',
        'brand_image',
    ];

    // Relationships

    // Brand has many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
