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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->unsignedInteger('progress')->default(0)->after('status');
            $table->foreignId('last_accessed_lesson_id')->nullable()->after('progress')->constrained('lessons')->onDelete('set null');
            $table->timestamp('last_accessed_at')->nullable()->after('last_accessed_lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['last_accessed_lesson_id']);
            $table->dropColumn(['progress', 'last_accessed_lesson_id', 'last_accessed_at']);
        });
    }
};
