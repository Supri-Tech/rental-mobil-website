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
        Schema::create('car_availability', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('car_id')->nullable();
            $table->date('date')->nullable();
            $table->boolean('is_available')->nullable()->default(true);
            $table->string('booked_by_transaction_ID', 50)->nullable();

            $table->unique(['car_id', 'date'], 'car_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_availability');
    }
};
