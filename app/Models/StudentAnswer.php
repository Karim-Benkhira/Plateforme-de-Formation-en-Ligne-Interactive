<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'option_id',
        'text_answer',
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
     * Get the user that owns the student answer
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that owns the student answer
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the option that owns the student answer
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
