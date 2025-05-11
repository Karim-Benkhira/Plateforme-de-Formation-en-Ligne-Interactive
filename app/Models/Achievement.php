<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
        'points',
        'criteria',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'criteria' => 'array',
    ];

    /**
     * Get the users that have earned this achievement.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements', 'achievement_id', 'user_id')
            ->withTimestamps();
    }
}
