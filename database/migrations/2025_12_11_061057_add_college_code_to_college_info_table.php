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
        Schema::table('college_info', function (Blueprint $table) {
            $table->string('college_code', 10)->nullable()->unique()->after('college_name');
            $table->index('college_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('college_info', function (Blueprint $table) {
            $table->dropIndex(['college_code']);
            $table->dropColumn('college_code');
        });
    }
};
