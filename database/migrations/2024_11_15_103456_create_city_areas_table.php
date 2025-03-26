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
        Schema::create('city_areas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id')->unsigned();
            $table->string('area_name', 50);
            $table->integer('pincode');
            $table->decimal('latitude',10, 7)->nullable();
            $table->decimal('longitude',10, 7)->nullable();
            $table->enum('status', ['active','in-active'])->default('active');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_areas');
    }
};
