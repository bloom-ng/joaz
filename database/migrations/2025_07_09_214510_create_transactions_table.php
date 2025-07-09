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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('gateway', ['paystack']);
            $table->string('transaction_reference');
            $table->double('amount');
            $table->enum('currency', ['NGN', 'USD']);
            $table->enum('status', ['pending', 'successful', 'failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->json('response_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
