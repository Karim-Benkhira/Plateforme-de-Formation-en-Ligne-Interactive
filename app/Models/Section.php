<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order_index',
        'is_published',
        'estimated_duration', // in minutes
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'estimated_duration' => 'integer',
    ];

    /**
     * Get the course that owns the section.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the section.
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order_index');
    }

    /**
     * Get published lessons for the section.
     */
    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->where('is_published', true)->orderBy('order_index');
    }

    /**
     * Get the total duration of all lessons in this section.
     */
    public function getTotalDurationAttribute()
    {
        return $this->lessons()->sum('duration');
    }

    /**
     * Get the total number of lessons in this section.
     */
    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    /**
     * Get the total number of published lessons in this section.
     */
    public function getPublishedLessonsCountAttribute()
    {
        return $this->publishedLessons()->count();
    }

    /**
     * Check if the section is complete (has at least one lesson).
     */
    public function getIsCompleteAttribute()
    {
        return $this->lessons()->count() > 0;
    }

    /**
     * Get the completion percentage of this section.
     */
    public function getCompletionPercentageAttribute()
    {
        $totalLessons = $this->lessons_count;
        $publishedLessons = $this->published_lessons_count;
        
        if ($totalLessons === 0) {
            return 0;
        }
        
        return round(($publishedLessons / $totalLessons) * 100);
    }

    /**
     * Scope a query to only include published sections.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order sections by their order index.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    /**
     * Get the next section in the course.
     */
    public function getNextSectionAttribute()
    {
        return Section::where('course_id', $this->course_id)
            ->where('order_index', '>', $this->order_index)
            ->orderBy('order_index')
            ->first();
    }

    /**
     * Get the previous section in the course.
     */
    public function getPreviousSectionAttribute()
    {
        return Section::where('course_id', $this->course_id)
            ->where('order_index', '<', $this->order_index)
            ->orderBy('order_index', 'desc')
            ->first();
    }
}
