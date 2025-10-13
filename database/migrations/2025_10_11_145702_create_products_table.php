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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('processor')->nullable();
            $table->string('os')->nullable();
            $table->string('battery')->nullable();
            $table->string('charging')->nullable();
            $table->string('display')->nullable();
            $table->string('resolution')->nullable();
            $table->string('camera')->nullable();
            $table->string('front_camera')->nullable();
            $table->string('network')->nullable();
            $table->string('sim')->nullable();
            $table->string('build')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('colors')->nullable();
            $table->string('fingerprint')->nullable();
            $table->string('water_resistance')->nullable();
            $table->string('bluetooth')->nullable();
            $table->string('wifi')->nullable();
            $table->string('usb')->nullable();
            $table->string('audio')->nullable();
            $table->string('sensors')->nullable();
            $table->string('release_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
