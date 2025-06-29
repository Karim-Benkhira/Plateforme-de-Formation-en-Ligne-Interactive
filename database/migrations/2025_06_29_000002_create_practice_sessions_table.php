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
        Schema::create('practice_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            
            // Session configuration
            $table->integer('total_questions');
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->enum('question_type', ['multiple_choice', 'true_false', 'mixed']);
            $table->string('language', 5)->default('en');
            
            // Session progress
            $table->integer('questions_answered')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->decimal('score_percentage', 5, 2)->nullable();
            
            // Session timing
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('total_time_seconds')->nullable();
            
            // AI generation info
            $table->string('ai_service_used')->nullable(); // gemini, fallback
            $table->boolean('used_fallback')->default(false);
            $table->text('content_summary')->nullable(); // Summary of course content used
            
            // Session status
            $table->enum('status', ['active', 'completed', 'abandoned'])->default('active');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'course_id']);
            $table->index(['status', 'started_at']);
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_sessions');
    }
};
