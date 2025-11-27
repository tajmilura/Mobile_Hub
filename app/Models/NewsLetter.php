<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime'
    ];

    /**
     * Scope active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Subscribe an email
     */
    public static function subscribe($email)
    {
        return static::updateOrCreate(
            ['email' => $email],
            ['is_active' => true]
        );
    }

    /**
     * Unsubscribe an email
     */
    public static function unsubscribe($email)
    {
        return static::where('email', $email)->update(['is_active' => false]);
    }
}
