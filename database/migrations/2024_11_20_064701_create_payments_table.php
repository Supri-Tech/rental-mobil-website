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
            $table->integer('id', true);
            $table->string('transaction_id', 50)->nullable()->index('transaction_id');
            $table->string('payment_method', 50)->nullable();
            $table->decimal('payment_amount', 10)->nullable();
            $table->timestamp('payment_date')->useCurrent();
            $table->text('midtrans_token')->nullable();
            $table->enum('status', ['Pending', 'Success', 'Failed'])->nullable()->default('Pending');
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
