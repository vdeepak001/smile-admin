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
        Schema::create('batch_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('student_id');
            $table->string('assigned_by')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('batch_id')->references('id')->on('college_batches')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');

            // Unique constraint to prevent duplicate assignments
            $table->unique(['batch_id', 'student_id']);

            // Indexes for better query performance
            $table->index('batch_id');
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_student');
    }
};
