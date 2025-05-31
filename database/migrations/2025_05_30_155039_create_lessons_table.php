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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('content_type', ['video', 'text', 'pdf', 'quiz', 'assignment'])->default('video');
            $table->string('content_url')->nullable(); // for external videos
            $table->string('content_file')->nullable(); // for uploaded files
            $table->longText('content_text')->nullable(); // for text content
            $table->integer('duration')->nullable(); // in minutes
            $table->integer('order_index')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_free')->default(false); // for preview lessons
            $table->enum('video_provider', ['youtube', 'vimeo', 'local'])->nullable();
            $table->string('video_id')->nullable(); // for external videos
            $table->string('thumbnail')->nullable();
            $table->json('resources')->nullable(); // additional resources
            $table->timestamps();

            // Indexes
            $table->index(['section_id', 'order_index']);
            $table->index(['section_id', 'is_published']);
            $table->index(['content_type']);
            $table->index(['is_free']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
