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
        if (Schema::hasColumn('courses', 'college_id')) {
            try {
                Schema::table('courses', function (Blueprint $table) {
                    $table->dropForeign(['college_id']);
                });
            } catch (\Throwable $e) {
                // Ignore if foreign key doesn't exist
            }

            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('college_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('courses', 'college_id')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->foreignId('college_id')->constrained('college_info', 'college_id')->onDelete('cascade');
            });
        }
    }
};
