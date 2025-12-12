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
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedSmallInteger('start_year')->nullable()->after('year_of_study');
            $table->unsignedSmallInteger('end_year')->nullable()->after('start_year');
            
            // Add indexes for performance
            $table->index('start_year');
            $table->index('end_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['start_year']);
            $table->dropIndex(['end_year']);
            $table->dropColumn(['start_year', 'end_year']);
        });
    }
};
