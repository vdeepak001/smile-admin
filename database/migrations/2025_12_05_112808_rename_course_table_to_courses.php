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
        // This migration is no longer needed - 'courses' table is already created with the correct name
        // Kept for backward compatibility
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed - this migration is a no-op
    }
};
