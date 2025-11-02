<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderAndBanner extends Model
{
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'highlight_text',
        'price',
        'image_path',
        'link',
        'order',
        'status',
    ];
      protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];
}
