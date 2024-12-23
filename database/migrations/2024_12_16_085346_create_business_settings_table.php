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
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->boolean('is_appointment_system')->default(false);
            $table->boolean('is_appointment_book_with_time_slote')->default(false)->comment('TRUE = book appointment with time slote, FALSE = using queue system');
            $table->boolean('is_appointment_with_department')->default(false)->comment('TRUE = department is mendetory, FALSE = department Not mandetory');
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
