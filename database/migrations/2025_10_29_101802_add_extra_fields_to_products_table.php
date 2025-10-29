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
        Schema::table('products', function (Blueprint $table) {
            // Extras fields
            $table->string('warranty')->nullable()->after('is_hot_deal'); // e.g., "1 year"
            $table->json('tags')->nullable()->after('warranty');          // ["gaming", "android", "5G"]
            $table->string('sku')->nullable()->after('tags');             // stock keeping unit
            $table->string('barcode')->nullable()->after('sku');          // optional barcode

            // Discount date & time
            $table->timestamp('discount_start')->nullable()->after('discount_price');
            $table->timestamp('discount_end')->nullable()->after('discount_start');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['warranty', 'tags', 'sku', 'barcode', 'discount_start', 'discount_end']);
        });
    }
};
