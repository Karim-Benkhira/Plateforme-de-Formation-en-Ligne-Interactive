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
        Schema::create('student_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('photo_path'); // Path to the stored photo
            $table->string('photo_hash')->nullable(); // Hash for quick comparison
            $table->json('face_encoding')->nullable(); // Face encoding data for comparison
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->string('upload_method')->default('upload'); // 'upload' or 'capture'
            $table->timestamps();
            
            // Ensure one photo per student
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_photos');
    }
};
