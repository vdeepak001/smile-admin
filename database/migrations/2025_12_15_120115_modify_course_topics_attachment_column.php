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
        Schema::table('course_topics', function (Blueprint $table) {
            // Change attachment column from VARCHAR to TEXT to store JSON data
            $table->text('attachment')->nullable()->change();
            
            // Remove the topic_pic column as it's no longer needed
            $table->dropColumn('topic_pic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_topics', function (Blueprint $table) {
            // Revert attachment column back to string
            $table->string('attachment')->nullable()->change();
            
            // Re-add topic_pic column
            $table->string('topic_pic')->nullable()->after('description');
        });
    }
};
