<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'quiz_id',
        'is_active',
        'started_at',
        'last_verified_at',
        'terminated_at',
        'termination_reason',
        'verification_count',
        'failed_verifications',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'started_at' => 'datetime',
        'last_verified_at' => 'datetime',
        'terminated_at' => 'datetime',
        'verification_count' => 'integer',
        'failed_verifications' => 'integer',
    ];

    /**
     * Get the user that owns the exam session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz for this exam session.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
