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
            // Drop email_id and password columns
            $table->dropUnique(['email_id']);
            $table->dropColumn(['email_id', 'password']);

            // Add user_id foreign key
            $table->foreignId('user_id')->after('college_name')->constrained('users')->onDelete('cascade');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('college_info', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropColumn(['user_id']);

            // Restore email_id and password columns
            $table->string('email_id')->unique()->after('college_name');
            $table->string('password')->after('email_id');
        });
    }
};
