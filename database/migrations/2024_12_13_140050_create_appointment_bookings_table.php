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
        Schema::create('appointment_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('token_number');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('appointmenter_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_contact')->nullable();
            $table->dateTime('slot_start_time')->nullable();
            $table->dateTime('slot_end_time')->nullable();
            $table->date('booking_date');
            $table->enum('status', ['pending', 'complete', 'cancel'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('business_id')->references('id')->on('businesses')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('appointment_departments')->cascadeOnDelete();
            $table->foreign('appointmenter_id')->references('id')->on('appointmenters')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_bookings');
    }
};
