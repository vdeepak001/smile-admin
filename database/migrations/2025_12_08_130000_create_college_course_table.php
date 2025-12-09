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
        Schema::create('college_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->constrained('college_info', 'college_id')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses', 'course_id')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['college_id', 'course_id']);
        });

        // Drop the course_id column from college_info
        if (Schema::hasColumn('college_info', 'course_id')) {
            Schema::table('college_info', function (Blueprint $table) {
                $table->dropColumn('course_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('college_course');

        if (!Schema::hasColumn('college_info', 'course_id')) {
             Schema::table('college_info', function (Blueprint $table) {
                $table->string('course_id')->nullable();
            });
        }
    }
};
