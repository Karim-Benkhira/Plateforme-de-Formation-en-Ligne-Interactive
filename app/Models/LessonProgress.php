<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'lesson_id',
        'is_completed',
        'progress_percentage',
        'time_spent', // in seconds
        'last_position', // for video lessons, in seconds
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_completed' => 'boolean',
        'progress_percentage' => 'integer',
        'time_spent' => 'integer',
        'last_position' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lesson that owns the progress.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Mark the lesson as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'is_completed' => true,
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);
    }

    /**
     * Update progress percentage.
     */
    public function updateProgress($percentage)
    {
        $this->update([
            'progress_percentage' => min(100, max(0, $percentage)),
            'is_completed' => $percentage >= 100,
            'completed_at' => $percentage >= 100 ? now() : null,
        ]);
    }

    /**
     * Update video position.
     */
    public function updateVideoPosition($position)
    {
        $this->update([
            'last_position' => $position,
        ]);
    }

    /**
     * Add time spent on the lesson.
     */
    public function addTimeSpent($seconds)
    {
        $this->increment('time_spent', $seconds);
    }

    /**
     * Get formatted time spent.
     */
    public function getFormattedTimeSpentAttribute()
    {
        if (!$this->time_spent) {
            return '0m';
        }

        $hours = floor($this->time_spent / 3600);
        $minutes = floor(($this->time_spent % 3600) / 60);

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        }

        return sprintf('%dm', $minutes);
    }

    /**
     * Get formatted last position for videos.
     */
    public function getFormattedLastPositionAttribute()
    {
        if (!$this->last_position) {
            return '0:00';
        }

        $minutes = floor($this->last_position / 60);
        $seconds = $this->last_position % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
