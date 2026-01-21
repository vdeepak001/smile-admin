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
            $table->string('test_type')->nullable()->after('course_id')->comment('pre, topic, final');
            $table->unsignedBigInteger('topic_id')->nullable()->after('test_type');
            $table->foreign('topic_id')->references('topic_id')->on('course_topics');
        });

        Schema::table('answered', function (Blueprint $table) {
             $table->string('test_type')->nullable()->after('topic_id')->comment('pre, topic, final');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropForeign(['topic_id']);
            $table->dropColumn(['test_type', 'topic_id']);
        });

        Schema::table('answered', function (Blueprint $table) {
            $table->dropColumn(['test_type']);
        });
    }
};
