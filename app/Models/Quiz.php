<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';
    protected $fillable = [
        'name',
        'description',
        'course_id',
        'duration',
        'passing_score',
        'attempts_allowed',
        'is_published',
        'requires_face_verification',
        'is_ai_generated',
        'creator_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

}
