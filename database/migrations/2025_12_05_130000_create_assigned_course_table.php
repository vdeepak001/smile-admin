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
        Schema::create('assigned_course', function (Blueprint $table) {
            $table->id('assigned_course_id');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->enum('completion_status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('assigned_on')->nullable();
            $table->softDeletes();

            // Indexes
            $table->index('student_id');
            $table->index('course_id');
            $table->index('completion_status');
            $table->unique(['student_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_course');
    }
};
