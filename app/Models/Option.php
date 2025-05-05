<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'option_text',
        'question_id',
        'is_correct',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the question that owns the option
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the student answers for the option
     */
    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
