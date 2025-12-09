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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->boolean('active_status')->default(true);
            $table->unsignedBigInteger('college_id')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('college_rights')->default(false);
            $table->boolean('course_rights')->default(false);
            $table->boolean('students_rights')->default(false);
            $table->softDeletes();

            // Add indexes for frequently queried columns
            $table->index('role');
            $table->index('college_id');
            $table->index('active_status');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropIndex(['role']);
            $table->dropIndex(['college_id']);
            $table->dropIndex(['active_status']);
            $table->dropIndex(['created_by']);
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone_number',
                'avatar',
                'active_status',
                'created_by',
                'updated_by',
                'college_id',
                'college_rights',
                'course_rights',
                'students_rights',
                'deleted_at',
            ]);
        });
    }
};
