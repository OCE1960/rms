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
        Schema::table('transcript_requests', function (Blueprint $table) {
            $table->boolean('has_provided_feedback')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transcript_requests', function (Blueprint $table) {
            $table->dropColumn('has_provided_feedback');
        });
    }
};
