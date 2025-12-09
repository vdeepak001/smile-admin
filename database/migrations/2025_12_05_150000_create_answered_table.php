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
        Schema::create('answered', function (Blueprint $table) {
            $table->id('answered_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->foreignId('topic_id')->constrained('course_topics', 'topic_id')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions', 'question_id')->onDelete('cascade');
            $table->integer('sequence');
            $table->string('answered_choice')->nullable();
            $table->enum('answered_status', ['correct', 'incorrect', 'skipped'])->default('skipped');
            $table->integer('time_taken')->default(0); // in seconds
            $table->timestamp('answered_date')->nullable();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('course_id');
            $table->index('topic_id');
            $table->index('question_id');
            $table->index('answered_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answered');
    }
};
