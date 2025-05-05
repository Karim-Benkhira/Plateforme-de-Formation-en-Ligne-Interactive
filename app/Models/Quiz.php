<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'lesson_id',
        'duration',
        'type',
        'status',
        'requires_face_recognition',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requires_face_recognition' => 'boolean',
    ];

    /**
     * Get the lesson that owns the quiz
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the questions for the quiz
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the quiz results for the quiz
     */
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    /**
     * Get the face recognition logs for the quiz
     */
    public function faceRecognitionLogs()
    {
        return $this->hasMany(FaceRecognitionLog::class);
    }

    /**
     * Get the total points for the quiz
     */
    public function getTotalPointsAttribute()
    {
        return $this->questions()->sum('points');
    }
}
