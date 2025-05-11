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
        Schema::table('quizzes', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->integer('duration')->default(30)->after('description');
            $table->integer('passing_score')->default(70)->after('duration');
            $table->integer('attempts_allowed')->default(1)->after('passing_score');
            $table->boolean('is_published')->default(false)->after('attempts_allowed');
            $table->boolean('requires_face_verification')->default(false)->after('is_published');
            $table->foreignId('creator_id')->nullable()->after('requires_face_verification')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
            $table->dropColumn([
                'description',
                'duration',
                'passing_score',
                'attempts_allowed',
                'is_published',
                'requires_face_verification',
                'creator_id'
            ]);
        });
    }
};
