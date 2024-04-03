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
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('work_item_id')->nullable()->constrained('work_items')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('send_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('send_to')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->boolean('is_task_completed')->default(false);
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
        Schema::dropIfExists('task_assignments');
    }
};
