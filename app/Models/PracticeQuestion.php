<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PracticeQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'type',
        'question',
        'options',
        'correct_answer',
        'explanation',
        'sample_answer',
        'key_points',
        'difficulty',
        'language',
        'is_ai_generated',
        'ai_service',
        'user_answer',
        'is_correct',
        'answered_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
        'key_points' => 'array',
        'is_ai_generated' => 'boolean',
        'is_correct' => 'boolean',
        'answered_at' => 'datetime',
    ];

    /**
     * Get the user that owns the practice question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that this practice question belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope to get questions for a specific user and course.
     */
    public function scopeForUserAndCourse($query, $userId, $courseId)
    {
        return $query->where('user_id', $userId)->where('course_id', $courseId);
    }

    /**
     * Scope to get unanswered questions.
     */
    public function scopeUnanswered($query)
    {
        return $query->whereNull('user_answer');
    }

    /**
     * Scope to get answered questions.
     */
    public function scopeAnswered($query)
    {
        return $query->whereNotNull('user_answer');
    }

    /**
     * Scope to get questions by difficulty.
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope to get questions by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if the question has been answered.
     */
    public function isAnswered(): bool
    {
        return !is_null($this->user_answer);
    }

    /**
     * Get the difficulty level in a human-readable format.
     */
    public function getDifficultyLabelAttribute(): string
    {
        $labels = [
            'easy' => 'Easy',
            'medium' => 'Medium',
            'hard' => 'Hard'
        ];

        return $labels[$this->difficulty] ?? ucfirst($this->difficulty);
    }

    /**
     * Get the question type in a human-readable format.
     */
    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'multiple_choice' => 'Multiple Choice',
            'true_false' => 'True/False',
            'short_answer' => 'Short Answer'
        ];

        return $labels[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    /**
     * Answer the question.
     */
    public function answer(string $userAnswer): bool
    {
        $this->user_answer = $userAnswer;
        $this->answered_at = now();

        // Check if the answer is correct
        $this->is_correct = $this->checkAnswer($userAnswer);

        $this->save();

        return $this->is_correct;
    }

    /**
     * Check if the provided answer is correct.
     */
    protected function checkAnswer(string $userAnswer): bool
    {
        switch ($this->type) {
            case 'multiple_choice':
            case 'true_false':
                return strtolower(trim($userAnswer)) === strtolower(trim($this->correct_answer));

            case 'short_answer':
                // For short answers, we'll do a simple keyword matching
                $userWords = array_map('strtolower', explode(' ', trim($userAnswer)));
                $keyPoints = array_map('strtolower', $this->key_points ?? []);

                $matches = 0;
                foreach ($keyPoints as $point) {
                    foreach ($userWords as $word) {
                        if (strpos($point, $word) !== false || strpos($word, $point) !== false) {
                            $matches++;
                            break;
                        }
                    }
                }

                // Consider correct if at least 50% of key points are mentioned
                return $matches >= (count($keyPoints) * 0.5);

            default:
                return false;
        }
    }

    /**
     * Get statistics for practice questions.
     */
    public static function getStatistics($userId, $courseId = null): array
    {
        $query = static::where('user_id', $userId);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        $total = $query->count();
        $answered = $query->whereNotNull('user_answer')->count();
        $correct = $query->where('is_correct', true)->count();

        $accuracy = $answered > 0 ? round(($correct / $answered) * 100, 2) : 0;

        return [
            'total' => $total,
            'answered' => $answered,
            'unanswered' => $total - $answered,
            'correct' => $correct,
            'incorrect' => $answered - $correct,
            'accuracy' => $accuracy
        ];
    }
}
