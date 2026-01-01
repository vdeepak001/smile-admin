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
        Schema::create('college_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id')->unique(); // COL-2022-001 format
            $table->unsignedBigInteger('college_id');
            $table->foreign('college_id')->references('college_id')->on('college_info')->onDelete('cascade');
            $table->json('courses')->nullable(); // Multi-select courses
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('batch_type')->default(1); // 1, 2, or 3
            $table->boolean('active_status')->default(true);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('college_batches');
    }
};
