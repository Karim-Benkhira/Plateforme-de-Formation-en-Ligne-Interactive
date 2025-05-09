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
        'role'
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

    public function hasRole($role)
    {
        return $this->role === $role;
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
}
