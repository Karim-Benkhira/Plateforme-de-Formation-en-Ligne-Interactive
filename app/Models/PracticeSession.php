<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PracticeSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'user_id',
        'course_id',
        'total_questions',
        'difficulty',
        'question_type',
        'language',
        'questions_answered',
        'correct_answers',
        'score_percentage',
        'started_at',
        'completed_at',
        'total_time_seconds',
        'ai_service_used',
        'used_fallback',
        'content_summary',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'used_fallback' => 'boolean',
        'score_percentage' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->session_id)) {
                $model->session_id = Str::uuid();
            }
            if (empty($model->started_at)) {
                $model->started_at = now();
            }
        });
    }

    /**
     * Get the user that owns the practice session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that this practice session belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the practice questions for this session.
     */
    public function practiceQuestions(): HasMany
    {
        return $this->hasMany(PracticeQuestion::class, 'session_id', 'session_id');
    }

    /**
     * Scope to get active sessions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get completed sessions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get sessions for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get sessions for a specific course.
     */
    public function scopeForCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Check if the session is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the session is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Complete the session.
     */
    public function complete(): void
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->total_time_seconds = $this->started_at->diffInSeconds(now());
        
        // Calculate final score
        $this->calculateScore();
        
        $this->save();
    }

    /**
     * Abandon the session.
     */
    public function abandon(): void
    {
        $this->status = 'abandoned';
        $this->save();
    }

    /**
     * Calculate and update the session score.
     */
    public function calculateScore(): void
    {
        $questions = $this->practiceQuestions()->answered()->get();
        
        $this->questions_answered = $questions->count();
        $this->correct_answers = $questions->where('is_correct', true)->count();
        
        if ($this->questions_answered > 0) {
            $this->score_percentage = round(($this->correct_answers / $this->questions_answered) * 100, 2);
        } else {
            $this->score_percentage = 0;
        }
    }

    /**
     * Get the session progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_questions <= 0) {
            return 0;
        }
        
        return round(($this->questions_answered / $this->total_questions) * 100, 2);
    }

    /**
     * Get the average time per question.
     */
    public function getAverageTimePerQuestionAttribute(): ?float
    {
        if ($this->questions_answered <= 0 || !$this->total_time_seconds) {
            return null;
        }
        
        return round($this->total_time_seconds / $this->questions_answered, 2);
    }

    /**
     * Get the session duration in human-readable format.
     */
    public function getDurationAttribute(): string
    {
        if (!$this->total_time_seconds) {
            return 'N/A';
        }
        
        $minutes = floor($this->total_time_seconds / 60);
        $seconds = $this->total_time_seconds % 60;
        
        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }
        
        return "{$seconds}s";
    }

    /**
     * Get performance grade based on score.
     */
    public function getGradeAttribute(): string
    {
        if (!$this->score_percentage) {
            return 'N/A';
        }
        
        if ($this->score_percentage >= 90) return 'A';
        if ($this->score_percentage >= 80) return 'B';
        if ($this->score_percentage >= 70) return 'C';
        if ($this->score_percentage >= 60) return 'D';
        
        return 'F';
    }

    /**
     * Get session statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total_questions' => $this->total_questions,
            'questions_answered' => $this->questions_answered,
            'correct_answers' => $this->correct_answers,
            'score_percentage' => $this->score_percentage,
            'progress_percentage' => $this->progress_percentage,
            'duration' => $this->duration,
            'average_time_per_question' => $this->average_time_per_question,
            'grade' => $this->grade,
            'ai_service_used' => $this->ai_service_used,
            'used_fallback' => $this->used_fallback,
        ];
    }

    /**
     * Get recent sessions for a user.
     */
    public static function getRecentForUser($userId, $limit = 10)
    {
        return static::forUser($userId)
            ->with(['course'])
            ->orderBy('started_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get performance summary for a user and course.
     */
    public static function getPerformanceSummary($userId, $courseId = null): array
    {
        $query = static::forUser($userId)->completed();
        
        if ($courseId) {
            $query->forCourse($courseId);
        }
        
        $sessions = $query->get();
        
        return [
            'total_sessions' => $sessions->count(),
            'average_score' => $sessions->avg('score_percentage'),
            'best_score' => $sessions->max('score_percentage'),
            'total_questions_answered' => $sessions->sum('questions_answered'),
            'total_correct_answers' => $sessions->sum('correct_answers'),
            'total_time_spent' => $sessions->sum('total_time_seconds'),
            'average_session_duration' => $sessions->avg('total_time_seconds'),
        ];
    }
}
