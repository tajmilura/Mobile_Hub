<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name', 'site_title', 'tagline', 'site_logo', 'favicon',
        'email', 'phone', 'phone_alt', 'address', 'city', 'state', 'country', 'zipcode', 'google_map_embed',
        'meta_title', 'meta_description', 'meta_keywords',
        'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok',
        'about_us', 'terms_conditions', 'privacy_policy', 'refund_policy', 'shipping_policy', 'faq',
        'footer_text', 'copyright_text',
        'currency', 'currency_symbol', 'cod_enabled', 'sslcommerz_enabled', 'stripe_enabled',
        'smtp_host', 'smtp_port', 'smtp_user', 'smtp_password', 'smtp_encryption',
        'maintenance_mode', 'google_analytics_id', 'facebook_pixel_id',
        'timezone', 'language'
    ];

    protected $casts = [
        'cod_enabled' => 'boolean',
        'sslcommerz_enabled' => 'boolean',
        'stripe_enabled' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];

    /**
     * Get setting instance (singleton pattern)
     */
    public static function getSettings()
    {
        return static::firstOrCreate([]);
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode()
    {
        $settings = static::getSettings();
        return (bool) $settings->maintenance_mode;
    }

    /**
     * Enable maintenance mode
     */
    public static function enableMaintenanceMode()
    {
        $settings = static::getSettings();
        $settings->update(['maintenance_mode' => true]);
        return true;
    }

    /**
     * Disable maintenance mode
     */
    public static function disableMaintenanceMode()
    {
        $settings = static::getSettings();
        $settings->update(['maintenance_mode' => false]);
        return true;
    }

    /**
     * Toggle maintenance mode
     */
    public static function toggleMaintenanceMode()
    {
        $settings = static::getSettings();
        $settings->update(['maintenance_mode' => !$settings->maintenance_mode]);
        return $settings->maintenance_mode;
    }

    /**
     * Get maintenance mode status with additional info
     */
    public static function getMaintenanceInfo()
    {
        $settings = static::getSettings();
        return [
            'enabled' => (bool) $settings->maintenance_mode,
            'site_name' => $settings->site_name,
            'site_logo' => $settings->site_logo,
            'contact_email' => $settings->email,
            'contact_phone' => $settings->phone,
        ];
    }
}