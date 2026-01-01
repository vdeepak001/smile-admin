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
            $table->tinyInteger('college_package')->nullable()->after('college_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('college_info', function (Blueprint $table) {
            $table->dropColumn('college_package');
        });
    }
};
