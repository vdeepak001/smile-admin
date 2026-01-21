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
        Schema::table('marks', function (Blueprint $table) {
            // Drop old unique index
            $table->dropUnique('marks_student_id_course_id_unique');
            
            // Create new expanded unique index
            $table->unique(['student_id', 'course_id', 'test_type', 'topic_id'], 'marks_student_course_test_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropUnique('marks_student_course_test_unique');
            $table->unique(['student_id', 'course_id'], 'marks_student_id_course_id_unique');
        });
    }
};
