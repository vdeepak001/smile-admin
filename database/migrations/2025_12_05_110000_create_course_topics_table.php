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
        Schema::create('course_topics', function (Blueprint $table) {
            $table->id('topic_id');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->string('topic_name');
            $table->text('description')->nullable();
            $table->string('topic_pic')->nullable();
            $table->string('attachment')->nullable();
            $table->foreignId('inserted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('inserted_on')->nullable();
            $table->timestamp('updated_on')->nullable();
            $table->boolean('active_status')->default(true);
            $table->softDeletes();

            // Indexes
            $table->index('course_id');
            $table->index('topic_name');
            $table->index('active_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_topics');
    }
};
