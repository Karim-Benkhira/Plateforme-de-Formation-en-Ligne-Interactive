<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_text',
        'quiz_id',
        'type',
        'points',
        'feedback',
    ];

    /**
     * Get the quiz that owns the question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the options for the question
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Get the student answers for the question
     */
    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    /**
     * Get the correct option for the question
     */
    public function getCorrectOptionAttribute()
    {
        return $this->options()->where('is_correct', true)->first();
    }
}
