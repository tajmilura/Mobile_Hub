<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'category_name',
        'category_icon',
        'category_image',
    ];

    // Relationships

    // Brand has many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
