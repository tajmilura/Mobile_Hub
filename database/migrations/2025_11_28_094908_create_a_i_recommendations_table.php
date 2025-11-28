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
        Schema::create('a_i_recommendations', function (Blueprint $table) {
           $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->text('user_input')->nullable();
        $table->json('recommendations')->nullable();
        $table->string('session_id')->nullable();
        $table->string('ip_address')->nullable();
        $table->text('user_agent')->nullable();
        $table->timestamps();

        // Indexes for better performance
        $table->index(['user_id', 'created_at']);
        $table->index('session_id');
        $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_i_recommendations');
    }
};
