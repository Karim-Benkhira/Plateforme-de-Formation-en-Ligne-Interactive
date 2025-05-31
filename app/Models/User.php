<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'profile_image',
        'bio',
        'specialization',
        'points'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole($roles)
    {
        // If $roles is a string with comma-separated values, convert it to an array
        if (is_string($roles) && strpos($roles, ',') !== false) {
            $roles = array_map('trim', explode(',', $roles));
        }

        // If $roles is a single string, convert it to an array
        if (is_string($roles)) {
            $roles = [$roles];
        }

        // Check if the user's role is in the array of allowed roles
        return in_array($this->role, $roles);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    /**
     * Get the face data associated with the user.
     */
    public function faceData()
    {
        return $this->hasOne(FaceData::class);
    }

    /**
     * Check if the user has registered their face.
     */
    public function hasFaceRegistered()
    {
        return $this->faceData && $this->faceData->face_descriptor !== null;
    }

    /**
     * Get the two-factor authentication configuration for the user.
     */
    public function twoFactorAuth()
    {
        return $this->hasOne(TwoFactorAuth::class);
    }

    /**
     * Check if the user has two-factor authentication enabled.
     */
    public function hasTwoFactorEnabled()
    {
        return $this->twoFactorAuth && $this->twoFactorAuth->enabled && $this->twoFactorAuth->confirmed_at !== null;
    }

    /**
     * Enable two-factor authentication for the user.
     */
    public function enableTwoFactorAuth($secretKey)
    {
        $twoFactorAuth = $this->twoFactorAuth ?? new TwoFactorAuth(['user_id' => $this->id]);
        $twoFactorAuth->secret_key = $secretKey;
        $twoFactorAuth->enabled = true;
        $twoFactorAuth->save();

        return $twoFactorAuth;
    }

    /**
     * Confirm two-factor authentication for the user.
     */
    public function confirmTwoFactorAuth()
    {
        if ($this->twoFactorAuth) {
            $this->twoFactorAuth->confirmed_at = now();
            $this->twoFactorAuth->save();

            return $this->twoFactorAuth->generateRecoveryCodes();
        }

        return null;
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disableTwoFactorAuth()
    {
        if ($this->twoFactorAuth) {
            $this->twoFactorAuth->enabled = false;
            $this->twoFactorAuth->confirmed_at = null;
            $this->twoFactorAuth->secret_key = null;
            $this->twoFactorAuth->recovery_codes = null;
            $this->twoFactorAuth->save();
        }
    }

    /**
     * Get the enrolled courses for the student.
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id')
            ->withPivot('progress', 'completed')
            ->withTimestamps();
    }

    /**
     * Get the completed courses for the student.
     */
    public function completedCourses()
    {
        return $this->enrolledCourses()->wherePivot('completed', true);
    }

    /**
     * Get the quiz results for the student.
     */
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    /**
     * Get the achievements for the student.
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements', 'user_id', 'achievement_id')
            ->withTimestamps();
    }

    /**
     * Get the recent activities for the student.
     */
    public function recentActivities()
    {
        return $this->hasMany(ActivityLog::class)->where('user_id', $this->id)->latest();
    }

    /**
     * Get the practice questions for the student.
     */
    public function practiceQuestions()
    {
        return $this->hasMany(\App\Models\PracticeQuestion::class);
    }
}
