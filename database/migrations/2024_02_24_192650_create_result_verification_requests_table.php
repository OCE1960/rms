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
        Schema::create('result_verification_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('enquirer_user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('school_id')->nullable()->constrained('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->string('student_first_name');
            $table->string('student_middle_name')->nullable();
            $table->string('student_last_name');
            $table->string('registration_no');
            $table->string('title_of_request')->nullable();
            $table->text('reason_for_request')->nullable();
            $table->boolean('has_paid')->default(false);
            $table->boolean('processing_status')->default(false);
            $table->boolean('is_result_verified')->default(false);
            $table->boolean('is_result_checked')->default(false);
            $table->boolean('is_result_recommended')->default(false);
            $table->boolean('is_result_approved')->default(false);
            $table->boolean('is_result_dispatched')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->foreignUuid('verified_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('checked_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('recommended_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('dispatched_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('archived_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_verification_requests');
    }
};
