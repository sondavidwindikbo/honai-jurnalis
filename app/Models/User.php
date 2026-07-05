<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function getFilamentDefaultPanel(): string
    {
        return match ($this->role) {
            'admin'   => 'admin',
            'editor'  => 'editor',
            'penulis' => 'penulis',
            default   => 'penulis',
        };
    }

    // INI YANG BARU — dipanggil otomatis oleh Filament saat login
    public function canAccessPanel(Panel $panel): bool
    {
        // Cek is_active dulu untuk semua panel
        if (!$this->is_active) return false;

        // Tiap role hanya boleh masuk panel miliknya
        return match ($panel->getId()) {
            'admin'   => $this->role === 'admin',
            'editor'  => $this->role === 'editor',
            'penulis' => $this->role === 'penulis',
            default   => false,
        };
    }

    // relasi & method lain tetap sama seperti sebelumnya
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isPenulis(): bool
    {
        return $this->role === 'penulis';
    }
    // public function routeNotificationForDatabase(): string
    // {
    //     return $this->getKey();
    // }
}
