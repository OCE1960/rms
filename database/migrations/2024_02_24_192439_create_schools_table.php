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
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('full_name')->unique();
            $table->string('short_name')->nullable()->unique();
            $table->string('address_street')->nullable();
            $table->string('address_mailbox')->nullable();
            $table->string('address_town')->nullable();
            $table->string('state')->nullable();
            $table->string('geo_zone')->nullable();
            $table->string('type')->nullable();
            $table->string('official_phone')->nullable();
            $table->string('official_email')->nullable();
            $table->string('official_website')->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
