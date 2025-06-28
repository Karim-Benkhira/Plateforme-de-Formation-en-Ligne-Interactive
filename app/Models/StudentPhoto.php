<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class StudentPhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'photo_path',
        'photo_hash',
        'face_encoding',
        'is_verified',
        'verified_at',
        'upload_method',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'face_encoding' => 'array',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the student photo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full URL to the photo.
     */
    public function getPhotoUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->photo_path);
    }

    /**
     * Check if the photo exists in storage.
     */
    public function photoExists(): bool
    {
        return Storage::disk('public')->exists($this->photo_path);
    }

    /**
     * Delete the photo from storage.
     */
    public function deletePhoto(): bool
    {
        if ($this->photoExists()) {
            return Storage::disk('public')->delete($this->photo_path);
        }
        return true;
    }

    /**
     * Mark the photo as verified.
     */
    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    /**
     * Check if face encoding is available for comparison.
     */
    public function hasFaceEncoding(): bool
    {
        return !empty($this->face_encoding);
    }
}
