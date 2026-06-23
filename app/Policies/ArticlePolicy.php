<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    // Siapa saja yang boleh LIHAT daftar artikel
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor', 'penulis']);
    }

    // Siapa yang boleh lihat DETAIL 1 artikel
    public function view(User $user, Article $article): bool
    {
        if ($user->role === 'admin' || $user->role === 'editor') {
            return true;
        }

        // Penulis cuma boleh lihat artikelnya sendiri
        return $user->id === $article->user_id;
    }

    // Siapa yang boleh BUAT artikel baru
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor', 'penulis']);
    }

    // Siapa yang boleh EDIT artikel
    public function update(User $user, Article $article): bool
    {
        if ($user->role === 'admin' || $user->role === 'editor') {
            return true;
        }

        // Penulis cuma boleh edit artikelnya sendiri, dan hanya kalau masih draft/rejected
        return $user->id === $article->user_id
            && in_array($article->status, ['draft', 'rejected']);
    }

    // Siapa yang boleh HAPUS artikel
    public function delete(User $user, Article $article): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        // Penulis cuma boleh hapus draft miliknya sendiri
        return $user->id === $article->user_id && $article->status === 'draft';
    }

    // Siapa yang boleh hapus banyak sekaligus (bulk delete)
    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}
