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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Payment Information
            $table->string('payment_method'); // cod, card, bkash, bank, nagad, rocket
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('BDT');
            $table->string('transaction_id')->nullable()->unique();
            $table->text('transaction_details')->nullable();

            // Payment Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'refunded'
            ])->default('pending');

            // Payment Gateway Response
            $table->text('gateway_response')->nullable();
            $table->string('gateway_name')->nullable(); // stripe, paypal, bkash, etc

            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['order_id', 'status']);
            $table->index('transaction_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
