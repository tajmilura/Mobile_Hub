<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;



    protected $fillable = [
        'email',
        'is_active',
        'subscribed_at' //  added this
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime'
    ];

    //  Auto timestamps disable
    public $timestamps = true;

    /**
     * Boot method for default values
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->subscribed_at)) {
                $model->subscribed_at = now();
            }
        });
    }

    /**
     * Scope active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope inactive subscriptions
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Subscribe an email
     */
    public static function subscribe($email)
    {
        return static::updateOrCreate(
            ['email' => $email],
            [
                'is_active' => true,
                'subscribed_at' => now() //  timestamp set করুন
            ]
        );
    }

    /**
     * Unsubscribe an email
     */
    public static function unsubscribe($email)
    {
        return static::where('email', $email)->update([
            'is_active' => false,
            // subscribed_at unchanged
        ]);
    }

    /**
     * Check if email is subscribed
     */
    public static function isSubscribed($email)
    {
        return static::where('email', $email)->where('is_active', true)->exists();
    }

    /**
     * Get active subscribers count
     */
    public static function getActiveCount()
    {
        return static::active()->count();
    }

    /**
     * Get today's subscribers
     */
    public static function getTodaySubscribers()
    {
        return static::whereDate('subscribed_at', today())->count();
    }
}
