<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id', 
        'question',
        'answers',
        'correct',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
