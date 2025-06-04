<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'creator_id',
        'score',
        'level',
        'is_published',
        'image',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot('progress', 'completed', 'status', 'approved_at', 'approved_by')
            ->withTimestamps();
    }

    /**
     * Get pending enrollment requests for this course.
     */
    public function pendingEnrollments()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot('progress', 'completed', 'status', 'approved_at', 'approved_by')
            ->wherePivot('status', 'pending')
            ->withTimestamps();
    }

    /**
     * Get approved enrollments for this course.
     */
    public function approvedEnrollments()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot('progress', 'completed', 'status', 'approved_at', 'approved_by')
            ->wherePivot('status', 'approved')
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the sections for the course.
     */
    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order_index');
    }

    /**
     * Get published sections for the course.
     */
    public function publishedSections()
    {
        return $this->hasMany(Section::class)->where('is_published', true)->orderBy('order_index');
    }

    /**
     * Get all lessons through sections.
     */
    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    /**
     * Get published lessons through sections.
     */
    public function publishedLessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class)
            ->where('lessons.is_published', true)
            ->orderBy('sections.order_index')
            ->orderBy('lessons.order_index');
    }

    /**
     * Get the total duration of all lessons in the course.
     */
    public function getTotalDurationAttribute()
    {
        return $this->lessons()->sum('duration');
    }

    /**
     * Get the formatted total duration.
     */
    public function getFormattedTotalDurationAttribute()
    {
        $totalMinutes = $this->total_duration;

        if (!$totalMinutes) {
            return 'N/A';
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        }

        return sprintf('%dm', $minutes);
    }

    /**
     * Get the total number of lessons in the course.
     */
    public function getTotalLessonsAttribute()
    {
        return $this->lessons()->count();
    }

    /**
     * Get the total number of published lessons in the course.
     */
    public function getPublishedLessonsCountAttribute()
    {
        return $this->publishedLessons()->count();
    }

    /**
     * Get the total number of sections in the course.
     */
    public function getTotalSectionsAttribute()
    {
        return $this->sections()->count();
    }

    /**
     * Get the completion percentage for a user.
     */
    public function getCompletionPercentageForUser($userId)
    {
        $totalLessons = $this->published_lessons_count;

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = LessonProgress::whereIn('lesson_id', $this->publishedLessons()->pluck('id'))
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100);
    }

    /**
     * Check if the course is complete (has at least one section with lessons).
     */
    public function getIsCompleteAttribute()
    {
        return $this->sections()->whereHas('lessons')->count() > 0;
    }



    /**
     * Get the course difficulty level label.
     */
    public function getDifficultyLabelAttribute()
    {
        $labels = [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
        ];

        return $labels[$this->level] ?? ucfirst($this->level);
    }

    /**
     * Get the course status label.
     */
    public function getStatusLabelAttribute()
    {
        if (!$this->is_published) {
            return 'Draft';
        }

        if (!$this->is_complete) {
            return 'In Progress';
        }

        return 'Published';
    }

    /**
     * Get the course image URL.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // For Docker environment, ensure proper path
        if (app()->environment('local') && str_contains(config('app.url'), 'localhost')) {
            return asset('storage/' . $this->image);
        }

        return asset('storage/' . $this->image);
    }

    /**
     * Get the course thumbnail URL with fallback.
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        // Return default course image with course title
        return route('images.default-course', ['title' => urlencode($this->title)]);
    }
}