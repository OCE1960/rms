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
        Schema::create('semesters', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('semester_session')->nullable();
            $table->foreignUuid('school_id')->nullable()->constrained('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('semester_name')->nullable();
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
        Schema::dropIfExists('semesters');
    }
};
