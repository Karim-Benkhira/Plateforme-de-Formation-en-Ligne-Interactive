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
    Schema::table('course_user', function (Blueprint $table) {
        
        if (!Schema::hasColumn('course_user', 'status')) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('completed');
        }
        if (!Schema::hasColumn('course_user', 'approved_at')) {
            $table->timestamp('approved_at')->nullable()->after('status');
        }
        if (!Schema::hasColumn('course_user', 'approved_by')) {
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'approved_at', 'approved_by']);
        });
    }
};
