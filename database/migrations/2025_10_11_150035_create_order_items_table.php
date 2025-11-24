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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Product Information (Snapshot at time of order)
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->decimal('product_price', 10, 2); // Original price
            $table->decimal('sale_price', 10, 2); // Actual selling price
            $table->integer('quantity')->default(1);
            
            // Pricing Information
            $table->decimal('subtotal', 10, 2); // sale_price * quantity
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2); // subtotal + tax - discount
            
            // Variant Information
            $table->string('variant')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->text('variant_attributes')->nullable(); // JSON format
            
            // Item Status
            $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled', 'returned'])->default('pending');
            $table->text('return_reason')->nullable();
            $table->timestamp('returned_at')->nullable();
            
            // Digital Product Support
            $table->boolean('is_digital')->default(false);
            $table->string('download_link')->nullable();
            $table->string('license_key')->nullable();

            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['order_id', 'product_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
