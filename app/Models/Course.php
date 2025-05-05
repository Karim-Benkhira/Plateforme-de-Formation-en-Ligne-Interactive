<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
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
        'teacher_id',
        'start_date',
        'end_date',
        'status',
        'image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the teacher that owns the course
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the modules for the course
     */
    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    /**
     * Get the students enrolled in the course
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot('status', 'enrolled_at', 'completed_at')
            ->withTimestamps();
    }

    /**
     * Get the enrollments for the course
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
