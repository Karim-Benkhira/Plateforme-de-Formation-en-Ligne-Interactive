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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->integer('duration')->default(30); // Duration in minutes
            $table->enum('type', ['practice', 'exam'])->default('practice');
            $table->enum('status', ['open', 'closed'])->default('closed');
            $table->boolean('requires_face_recognition')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
