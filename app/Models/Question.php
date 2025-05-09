<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'type',
        'question',
        'answers',
        'options',
        'correct',
        'explanation',
        'difficulty',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the formatted answers based on question type
     *
     * @return array
     */
    public function getFormattedAnswers()
    {
        switch ($this->type) {
            case 'multiple_choice':
                return explode(',', $this->answers);

            case 'true_false':
                return ['True', 'False'];

            case 'matching':
            case 'drag_drop':
            case 'fill_blank':
                return $this->options['answers'] ?? [];

            default:
                return explode(',', $this->answers);
        }
    }

    /**
     * Check if an answer is correct
     *
     * @param mixed $answer
     * @return bool
     */
    public function isCorrect($answer)
    {
        switch ($this->type) {
            case 'multiple_choice':
                return (int) $answer === (int) $this->correct;

            case 'true_false':
                return (strtolower($answer) === 'true' && $this->correct === 0) ||
                       (strtolower($answer) === 'false' && $this->correct === 1);

            case 'matching':
                if (!is_array($answer)) return false;
                $correctMatches = $this->options['matches'] ?? [];
                foreach ($answer as $key => $value) {
                    if (!isset($correctMatches[$key]) || $correctMatches[$key] !== $value) {
                        return false;
                    }
                }
                return true;

            case 'drag_drop':
                if (!is_array($answer)) return false;
                $correctOrder = $this->options['correct_order'] ?? [];
                return $answer === $correctOrder;

            case 'fill_blank':
                if (!is_array($answer)) return false;
                $blanks = $this->options['blanks'] ?? [];
                foreach ($answer as $index => $value) {
                    if (!isset($blanks[$index]) || strtolower(trim($value)) !== strtolower(trim($blanks[$index]))) {
                        return false;
                    }
                }
                return true;

            default:
                return (int) $answer === (int) $this->correct;
        }
    }

    /**
     * Get difficulty level name
     *
     * @return string
     */
    public function getDifficultyName()
    {
        switch ($this->difficulty) {
            case 1:
                return 'Easy';
            case 2:
                return 'Medium';
            case 3:
                return 'Hard';
            default:
                return 'Medium';
        }
    }
}
