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
        Schema::create('slider_and_banners', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // slider, banner, etc.
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('highlight_text')->nullable(); // e.g., Save $70
            $table->string('price')->nullable(); // optional, slider price
            $table->string('image_path'); // image file path
            $table->string('link')->nullable(); // click URL
            $table->integer('order')->default(0); // display order
            $table->boolean('status')->default(false); // active / inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_and_banners');
    }
};
