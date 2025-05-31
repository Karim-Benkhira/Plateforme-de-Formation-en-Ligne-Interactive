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
        'section_id',
        'title',
        'description',
        'content_type', // video, text, pdf, quiz, assignment
        'content_url', // for videos (YouTube, Vimeo, etc.)
        'content_file', // for uploaded files
        'content_text', // for text content
        'duration', // in minutes
        'order_index',
        'is_published',
        'is_free', // for preview lessons
        'video_provider', // youtube, vimeo, local
        'video_id', // for external videos
        'thumbnail',
        'resources', // JSON array of additional resources
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'is_free' => 'boolean',
        'duration' => 'integer',
        'resources' => 'array',
    ];

    /**
     * Get the section that owns the lesson.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the course through the section.
     */
    public function course()
    {
        return $this->hasOneThrough(Course::class, Section::class, 'id', 'id', 'section_id', 'course_id');
    }

    /**
     * Get user progress for this lesson.
     */
    public function userProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Get user progress for a specific user.
     */
    public function progressForUser($userId)
    {
        return $this->userProgress()->where('user_id', $userId)->first();
    }

    /**
     * Check if a user has completed this lesson.
     */
    public function isCompletedByUser($userId)
    {
        $progress = $this->progressForUser($userId);
        return $progress && $progress->is_completed;
    }

    /**
     * Get the formatted duration.
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return 'N/A';
        }

        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        }

        return sprintf('%dm', $minutes);
    }

    /**
     * Get the content type icon.
     */
    public function getContentTypeIconAttribute()
    {
        $icons = [
            'video' => 'fas fa-play-circle',
            'text' => 'fas fa-file-alt',
            'pdf' => 'fas fa-file-pdf',
            'quiz' => 'fas fa-question-circle',
            'assignment' => 'fas fa-tasks',
        ];

        return $icons[$this->content_type] ?? 'fas fa-file';
    }

    /**
     * Get the content type label.
     */
    public function getContentTypeLabelAttribute()
    {
        $labels = [
            'video' => 'Video',
            'text' => 'Text',
            'pdf' => 'PDF',
            'quiz' => 'Quiz',
            'assignment' => 'Assignment',
        ];

        return $labels[$this->content_type] ?? ucfirst($this->content_type);
    }

    /**
     * Get the video embed URL for external videos.
     */
    public function getVideoEmbedUrlAttribute()
    {
        if ($this->video_provider === 'youtube' && $this->video_id) {
            return "https://www.youtube.com/embed/{$this->video_id}";
        }

        if ($this->video_provider === 'vimeo' && $this->video_id) {
            return "https://player.vimeo.com/video/{$this->video_id}";
        }

        return $this->content_url;
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }

        // Generate default thumbnail based on video provider
        if ($this->video_provider === 'youtube' && $this->video_id) {
            return "https://img.youtube.com/vi/{$this->video_id}/maxresdefault.jpg";
        }

        return asset('images/default-lesson-thumbnail.jpg');
    }

    /**
     * Scope a query to only include published lessons.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include free lessons.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope a query to order lessons by their order index.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }



    /**
     * Get the next lesson in the section.
     */
    public function getNextLessonAttribute()
    {
        return Lesson::where('section_id', $this->section_id)
            ->where('order_index', '>', $this->order_index)
            ->orderBy('order_index')
            ->first();
    }

    /**
     * Get the previous lesson in the section.
     */
    public function getPreviousLessonAttribute()
    {
        return Lesson::where('section_id', $this->section_id)
            ->where('order_index', '<', $this->order_index)
            ->orderBy('order_index', 'desc')
            ->first();
    }

    /**
     * Extract video ID from URL.
     */
    public static function extractVideoId($url, $provider)
    {
        if ($provider === 'youtube') {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
            return $matches[1] ?? null;
        }

        if ($provider === 'vimeo') {
            preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/', $url, $matches);
            return $matches[3] ?? null;
        }

        return null;
    }
}
