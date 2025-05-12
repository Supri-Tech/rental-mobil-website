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
        Schema::table('car_availability', function (Blueprint $table) {
            $table->foreign(['car_id'], 'car_availability_ibfk_1')->references(['id'])->on('cars')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_availability', function (Blueprint $table) {
            $table->dropForeign('car_availability_ibfk_1');
        });
    }
};
