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
        Schema::create('cars', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->nullable()->index('category_id');
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->string('license_plate', 20)->unique('license_plate');
            $table->integer('year')->nullable();
            $table->enum('transmission', ['Manual', 'Automatic', 'Semi-Automatic'])->nullable();
            $table->enum('fuel_type', ['Bensin', 'Diesel', 'Hybrid', 'Elektrik'])->nullable();
            $table->integer('passenger_capacity')->nullable();
            $table->decimal('base_price_per_day', 10)->nullable();
            $table->enum('status', ['Tersedia', 'Diperbaiki', 'Tidak Aktif'])->nullable()->default('Tersedia');
            $table->string('image_primary')->nullable();
            $table->text('images_additional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
