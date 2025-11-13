<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SettingController extends Controller
{
    //settings index
    public function index()
    {
        $setting = Setting::first();
        return view('admin.settings.settings', compact('setting'));
    }

public function update(Request $request)
{
    $request->validate([
        'site_name' => 'nullable|string|max:255',
        'site_title' => 'nullable|string|max:255',
        'tagline' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:20',
        'phone_alt' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'country' => 'nullable|string|max:100',
        'zipcode' => 'nullable|string|max:20',
        'favicon' => 'nullable|image|mimes:png,ico,jpg,jpeg|max:1024', // 1MB max
        'site_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',   // 2MB max
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
    ]);

    $settings = Setting::firstOrNew();

    // Basic Info
    $settings->site_name = $request->site_name;
    $settings->site_title = $request->site_title;
    $settings->tagline = $request->tagline;

    // Contact Info
    $settings->email = $request->email;
    $settings->phone = $request->phone;
    $settings->phone_alt = $request->phone_alt;
    $settings->address = $request->address;
    $settings->city = $request->city;
    $settings->state = $request->state;
    $settings->country = $request->country;
    $settings->zipcode = $request->zipcode;
    $settings->google_map_embed = $request->google_map_embed;

    // SEO
    $settings->meta_title = $request->meta_title;
    $settings->meta_description = $request->meta_description;
    $settings->meta_keywords = $request->meta_keywords;

    // Social Links
    $settings->facebook = $request->facebook;
    $settings->twitter = $request->twitter;
    $settings->instagram = $request->instagram;
    $settings->linkedin = $request->linkedin;
    $settings->youtube = $request->youtube;
    $settings->tiktok = $request->tiktok;

    // Website Pages
    $settings->about_us = $request->about_us;
    $settings->terms_conditions = $request->terms_conditions;
    $settings->privacy_policy = $request->privacy_policy;
    $settings->refund_policy = $request->refund_policy;
    $settings->shipping_policy = $request->shipping_policy;
    $settings->faq = $request->faq;

    // Footer
    $settings->footer_text = $request->footer_text;
    $settings->copyright_text = $request->copyright_text;

    // Payment Settings
    $settings->currency = $request->currency ?? 'BDT';
    $settings->currency_symbol = $request->currency_symbol ?? '৳';
    $settings->cod_enabled = $request->cod_enabled ?? false;
    $settings->sslcommerz_enabled = $request->sslcommerz_enabled ?? false;
    $settings->stripe_enabled = $request->stripe_enabled ?? false;

    // Mail / SMTP
    $settings->smtp_host = $request->smtp_host;
    $settings->smtp_port = $request->smtp_port;
    $settings->smtp_user = $request->smtp_user;
    $settings->smtp_password = $request->smtp_password;
    $settings->smtp_encryption = $request->smtp_encryption;

    // Maintenance & Analytics
    $settings->maintenance_mode = $request->maintenance_mode ?? false;
    $settings->google_analytics_id = $request->google_analytics_id;
    $settings->facebook_pixel_id = $request->facebook_pixel_id;

    $settings->timezone = $request->timezone ?? 'Asia/Dhaka';
    $settings->language = $request->language ?? 'en';

    $manager = new ImageManager(new Driver());
    // Favicon
    if ($request->hasFile('favicon')) {
        if ($settings->favicon && File::exists(storage_path('app/public/' . $settings->favicon))) {
            File::delete(storage_path('app/public/' . $settings->favicon));
        }

        $faviconName = 'favicon_' . uniqid() . '.' . $request->file('favicon')->getClientOriginalExtension();

        $faviconImage = $manager->read($request->file('favicon'));
        $faviconImage->resize(33, 33, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $faviconPath = storage_path('app/public/uploads/settings/');
        if (!File::exists($faviconPath)) {
            File::makeDirectory($faviconPath, 0755, true);
        }

        $faviconImage->save($faviconPath . $faviconName);
        $settings->favicon = 'uploads/settings/' . $faviconName;
    }

    // Site Logo
    if ($request->hasFile('site_logo')) {
        if ($settings->site_logo && File::exists(storage_path('app/public/' . $settings->site_logo))) {
            File::delete(storage_path('app/public/' . $settings->site_logo));
        }

        $logoName = 'logo_' . uniqid() . '.' . $request->file('site_logo')->getClientOriginalExtension();

        $logoImage = $manager->read($request->file('site_logo'));
        $logoImage->resize(105, 24, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $logoPath = storage_path('app/public/uploads/settings/');
        if (!File::exists($logoPath)) {
            File::makeDirectory($logoPath, 0755, true);
        }

        $logoImage->save($logoPath . $logoName);
        $settings->site_logo = 'uploads/settings/' . $logoName;
    }

    $settings->save();
    toastr('Settings updated successfully.', 'success');

    return redirect()->back();
}

}
