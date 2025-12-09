<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if foreign key constraint exists and drop it
        $constraint = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'users'
            AND COLUMN_NAME = 'college_id'
            AND CONSTRAINT_NAME != 'PRIMARY'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if ($constraint) {
            DB::statement("ALTER TABLE users DROP FOREIGN KEY `{$constraint->CONSTRAINT_NAME}`");
        }

        // Check if column exists, if not add it
        if (!Schema::hasColumn('users', 'college_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('college_id')->nullable()->after('active_status');
            });
        }

        // Recreate foreign key with correct reference
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('college_id')->references('college_id')->on('college_info')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['college_id']);
        });
    }
};
