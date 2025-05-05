<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'module_id',
        'content_type',
        'content_url',
        'order',
    ];

    /**
     * Get the module that owns the lesson
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the quizzes for the lesson
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the course through the module
     */
    public function course()
    {
        return $this->module->course();
    }
}
