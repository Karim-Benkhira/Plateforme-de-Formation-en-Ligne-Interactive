<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
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
        'course_id',
        'order',
    ];

    /**
     * Get the course that owns the module
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the module
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
}
