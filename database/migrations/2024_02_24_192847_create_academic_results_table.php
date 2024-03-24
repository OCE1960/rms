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
        Schema::create('academic_results', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('score')->nullable();
            $table->string('grade_point')->nullable();
            $table->string('grade')->nullable();
            $table->string('unit')->nullable();
            $table->foreignUuid('course_id')->nullable()->constrained('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('semester_id')->nullable()->constrained('semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_results');
    }
};
