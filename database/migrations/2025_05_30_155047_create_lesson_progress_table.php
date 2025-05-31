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
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->integer('progress_percentage')->default(0); // 0-100
            $table->integer('time_spent')->default(0); // in seconds
            $table->integer('last_position')->nullable(); // for video lessons, in seconds
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Unique constraint to prevent duplicate progress records
            $table->unique(['user_id', 'lesson_id']);

            // Indexes
            $table->index(['user_id', 'is_completed']);
            $table->index(['lesson_id', 'is_completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
    }
};
