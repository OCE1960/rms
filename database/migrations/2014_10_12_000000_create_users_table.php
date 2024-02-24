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
            $table->uuid('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('registration_no')->nullable()->unique();
            $table->string('phone_no')->unique()->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_picture_path')->nullable();
            $table->integer('ordinal')->nullable();
            $table->string('title')->nullable();
            $table->boolean('is_disabled')->default(false);
            $table->boolean('is_student')->default(false);
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_result_verifier')->default(false);
            $table->boolean('is_account_activated')->default(true);
            $table->boolean('is_first_login')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->primary('id');
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
