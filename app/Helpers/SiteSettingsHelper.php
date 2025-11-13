<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getSetting')) {
    /**
     * Get a setting value (cached).
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getSetting(string $key, $default = null)
    {
        // cache key and ttl (seconds)
        $cacheKey = 'site_settings';
        $ttl = 3600; // 1 hour, change if needed

        $settings = Cache::remember($cacheKey, $ttl, function () {
            return Setting::first();
        });

        // if no settings row, return default
        if (!$settings) {
            return $default;
        }

        return $settings->{$key} ?? $default;
    }
}

if (!function_exists('clearSettingsCache')) {
    /**
     * Clear settings cache.
     */
    function clearSettingsCache()
    {
        Cache::forget('site_settings');
    }
}

if (!function_exists('updateSettingsCache')) {
    /**
     * Force refresh settings cache from DB.
     */
    function updateSettingsCache()
    {
        $cacheKey = 'site_settings';
        $ttl = 3600; // match with getSetting

        $settings = Setting::first();
        if ($settings) {
            Cache::put($cacheKey, $settings, $ttl);
        } else {
            // if no settings row, ensure cache is cleared
            Cache::forget($cacheKey);
        }
    }
}
