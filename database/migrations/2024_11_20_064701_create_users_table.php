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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('username', 50)->unique('username');
            $table->string('email', 100)->unique('email');
            $table->string('password');
            $table->string('full_name', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('ktp_number', 20)->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('role', ['user', 'admin', 'superadmin'])->nullable()->default('user');
            $table->enum('status', ['active', 'inactive', 'banned'])->nullable()->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
