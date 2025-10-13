<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
        $table->id();

        // Basic Site Info
        $table->string('site_name')->nullable();
        $table->string('site_title')->nullable();
        $table->string('tagline')->nullable();
        $table->string('site_logo')->nullable();
        $table->string('favicon')->nullable();

        // Contact Info
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('phone_alt')->nullable();
        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->string('zipcode')->nullable();
        $table->string('google_map_embed')->nullable();

        // SEO
        $table->text('meta_title')->nullable();
        $table->longText('meta_description')->nullable();
        $table->text('meta_keywords')->nullable();

        // Social Media Links
        $table->string('facebook')->nullable();
        $table->string('twitter')->nullable();
        $table->string('instagram')->nullable();
        $table->string('linkedin')->nullable();
        $table->string('youtube')->nullable();
        $table->string('tiktok')->nullable();

        // Website Content Pages (Editable with CKEditor)
        $table->longText('about_us')->nullable();
        $table->longText('terms_conditions')->nullable();
        $table->longText('privacy_policy')->nullable();
        $table->longText('refund_policy')->nullable();
        $table->longText('shipping_policy')->nullable();
        $table->longText('faq')->nullable();

        // Footer
        $table->text('footer_text')->nullable();
        $table->string('copyright_text')->nullable();

        // Payment Settings (optional future integration)
        $table->string('currency')->default('BDT');
        $table->string('currency_symbol')->default('৳');
        $table->boolean('cod_enabled')->default(true);
        $table->boolean('sslcommerz_enabled')->default(false);
        $table->boolean('stripe_enabled')->default(false);

        // Mail / SMTP Settings
        $table->string('smtp_host')->nullable();
        $table->string('smtp_port')->nullable();
        $table->string('smtp_user')->nullable();
        $table->string('smtp_password')->nullable();
        $table->string('smtp_encryption')->nullable();

        // Maintenance Mode
        $table->boolean('maintenance_mode')->default(false);

        // Google / Analytics
        $table->string('google_analytics_id')->nullable();
        $table->string('facebook_pixel_id')->nullable();

        // Miscellaneous
        $table->string('timezone')->default('Asia/Dhaka');
        $table->string('language')->default('en');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
