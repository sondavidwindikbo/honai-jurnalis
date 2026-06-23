<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function view(User $user, Comment $comment): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function create(User $user): bool
    {
        return true; // semua role bisa, walau biasanya dari form publik
    }

    public function update(User $user, Comment $comment): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function delete(User $user, Comment $comment): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }
}
