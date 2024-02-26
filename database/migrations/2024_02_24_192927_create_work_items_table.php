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
        Schema::create('work_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('transcript_request_id')->nullable()->constrained('transcript_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('result_verification_request_id')->nullable()->constrained('result_verification_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('send_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('send_to')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_items');
    }
};
