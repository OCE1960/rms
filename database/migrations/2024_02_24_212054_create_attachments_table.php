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
        Schema::create('attachments', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('file_path')->nullable();
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->string('file_type')->nullable();
            $table->string('allow_viewer_user_role')->nullable();
            $table->boolean('is_student_copy')->default(false);
            $table->foreignUuid('transcript_request_id')->nullable()->constrained('transcript_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('requester_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('result_verification_request_id')->nullable()->constrained('result_verification_requests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
