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
        Schema::create('transcript_requests', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('school_id')->nullable()->constrained('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->string('send_by')->nullable();
            $table->string('title_of_request')->nullable();
            $table->text('reason_for_request')->nullable();
            $table->string('destination_country')->nullable();
            $table->string('receiving_institution')->nullable();
            $table->string('receiving_institution_corresponding_email')->nullable();
            $table->string('program')->nullable();
            $table->boolean('has_consent_letter')->default(false);
            $table->boolean('processing_status')->default(false);
            $table->boolean('is_result_compiled')->default(false);
            $table->boolean('is_result_checked')->default(false);
            $table->boolean('is_result_recommended')->default(false);
            $table->boolean('is_result_approved')->default(false);
            $table->boolean('is_result_dispatched')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->foreignUuid('compiled_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('checked_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('recommended_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('dispatched_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('archived_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('transcript_requests');
    }
};
