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
        Schema::table('college_batches', function (Blueprint $table) {
            $table->integer('final_test_questions_count')->nullable()->after('batch_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('college_batches', function (Blueprint $table) {
            $table->dropColumn('final_test_questions_count');
        });
    }
};
