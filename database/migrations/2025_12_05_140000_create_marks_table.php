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
        Schema::create('marks', function (Blueprint $table) {
            $table->id('marks_id');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->integer('total_questions')->default(0);
            $table->integer('completed_on')->default(0);
            $table->integer('answered_questions')->default(0);
            $table->integer('correct_answer')->default(0);
            $table->integer('wrong_answer')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->softDeletes();

            // Indexes
            $table->index('student_id');
            $table->index('course_id');
            $table->unique(['student_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
