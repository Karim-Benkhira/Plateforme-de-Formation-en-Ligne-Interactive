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
        Schema::create('practice_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer']);
            $table->text('question');
            $table->json('options')->nullable(); // For multiple choice questions
            $table->text('correct_answer')->nullable();
            $table->text('explanation')->nullable();
            $table->text('sample_answer')->nullable(); // For short answer questions
            $table->json('key_points')->nullable(); // For short answer questions
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->string('language', 5)->default('en'); // en, ar, fr
            $table->boolean('is_ai_generated')->default(true);
            $table->string('ai_service')->nullable(); // gemini, openai, huggingface
            $table->text('user_answer')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['user_id', 'course_id']);
            $table->index(['type', 'difficulty']);
            $table->index('is_ai_generated');
            $table->index('answered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_questions');
    }
};
