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
        Schema::table('practice_questions', function (Blueprint $table) {
            // Add session tracking
            $table->string('session_id')->nullable()->after('course_id');
            
            // Add content context tracking
            $table->text('content_context')->nullable()->after('ai_service');
            $table->json('content_keywords')->nullable()->after('content_context');
            
            // Add question generation metadata
            $table->string('generation_method')->default('ai')->after('is_ai_generated'); // ai, fallback, template
            $table->json('generation_metadata')->nullable()->after('generation_method');
            
            // Add performance tracking
            $table->integer('time_spent_seconds')->nullable()->after('is_correct');
            $table->integer('attempts_count')->default(1)->after('time_spent_seconds');
            
            // Add indexes for new fields
            $table->index('session_id');
            $table->index('generation_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practice_questions', function (Blueprint $table) {
            $table->dropIndex(['session_id']);
            $table->dropIndex(['generation_method']);
            
            $table->dropColumn([
                'session_id',
                'content_context',
                'content_keywords',
                'generation_method',
                'generation_metadata',
                'time_spent_seconds',
                'attempts_count'
            ]);
        });
    }
};
