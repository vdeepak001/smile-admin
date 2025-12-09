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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_name');
            $table->text('description')->nullable();
            $table->string('course_pic')->nullable();
            $table->integer('test_questions')->default(0);
            $table->integer('percent_require')->default(0);

            $table->foreignId('inserted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('inserted_on')->nullable();
            $table->timestamp('updated_on')->nullable();

            $table->boolean('active_status')->default(true);
            $table->softDeletes();

            // Indexes
            $table->index('course_name');

            $table->index('active_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
