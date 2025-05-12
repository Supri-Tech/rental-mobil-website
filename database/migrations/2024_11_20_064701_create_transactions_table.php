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
            $table->string('id', 50)->primary();
            $table->integer('user_id')->nullable()->index('user_id');
            $table->integer('car_id')->nullable()->index('car_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_days')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'On Progress', 'Completed', 'Cancelled'])->nullable()->default('Pending');
            $table->decimal('total_price', 10)->nullable();
            $table->enum('payment_status', ['Pending', 'Paid', 'Refund'])->nullable()->default('Pending');
            $table->boolean('with_driver')->nullable()->default(false);
            $table->string('pickup_location')->nullable();
            $table->string('return_location')->nullable();
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
