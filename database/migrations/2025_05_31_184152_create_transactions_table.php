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
            $table->string('payment_id')->unique()->index()->nullable();
            $table->double('amount', 10, 2);
            $table->enum('payment_type', ['cash', 'online'])->default('online');
            $table->date('transaction_date')->nullable();
            $table->date('refund_date')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded_requested', 'refunded'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
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
