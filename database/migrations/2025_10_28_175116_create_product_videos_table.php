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
        Schema::create('product_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // For uploaded videos
            $table->string('video_path')->nullable();

            // For embedded links
            $table->text('embed_link')->nullable(); // YouTube/Vimeo URL

            // Optional metadata
            $table->string('title')->nullable();
            $table->string('type')->nullable(); // 'local' or 'embed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_videos');
    }
};
