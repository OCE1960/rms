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
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('transcript_request_id')->nullable()->constrained('transcript_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('comment_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
