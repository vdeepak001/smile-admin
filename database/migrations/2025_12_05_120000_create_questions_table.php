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
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->foreignId('topic_id')->constrained('course_topics', 'topic_id')->onDelete('cascade');
            $table->string('question_type'); // multiple_choice, true_false, short_answer, etc.
            $table->text('question_text');
            $table->integer('level')->default(1); // difficulty level
            $table->string('pic_1')->nullable();
            $table->string('pic_2')->nullable();
            $table->string('pic_3')->nullable();
            $table->string('choice_1')->nullable();
            $table->string('choice_2')->nullable();
            $table->string('choice_3')->nullable();
            $table->string('choice_4')->nullable();
            $table->string('choice_pic_1')->nullable();
            $table->string('choice_pic_2')->nullable();
            $table->string('choice_pic_3')->nullable();
            $table->string('choice_pic_4')->nullable();
            $table->string('right_answer')->nullable();
            $table->text('reasoning')->nullable();
            $table->foreignId('inserted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('inserted_on')->nullable();
            $table->timestamp('updated_on')->nullable();
            $table->boolean('active_status')->default(true);
            $table->softDeletes();

            // Indexes
            $table->index('course_id');
            $table->index('topic_id');
            $table->index('question_type');
            $table->index('active_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
