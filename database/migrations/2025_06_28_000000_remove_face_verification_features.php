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
        // Drop face_data table if it exists
        Schema::dropIfExists('face_data');
        
        // Drop exam_sessions table if it exists
        Schema::dropIfExists('exam_sessions');
        
        // Remove requires_face_verification column from quizzes table if it exists
        if (Schema::hasTable('quizzes') && Schema::hasColumn('quizzes', 'requires_face_verification')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->dropColumn('requires_face_verification');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate face_data table
        Schema::create('face_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('face_descriptor')->nullable();
            $table->string('face_image_path')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamps();
        });

        // Recreate exam_sessions table
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_verified_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->string('termination_reason')->nullable();
            $table->integer('verification_count')->default(0);
            $table->integer('failed_verifications')->default(0);
            $table->timestamps();
        });

        // Add requires_face_verification column back to quizzes table
        if (Schema::hasTable('quizzes') && !Schema::hasColumn('quizzes', 'requires_face_verification')) {
            Schema::table('quizzes', function (Blueprint $table) {
                $table->boolean('requires_face_verification')->default(false)->after('is_published');
            });
        }
    }
};
