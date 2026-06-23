<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'guest_name',
        'guest_email',
        'body',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    // Komentar milik satu artikel
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Komentar bisa dari user login atau tamu
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: ambil nama komentator (user atau tamu)
    public function getAuthorNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Anonim';
    }
}
