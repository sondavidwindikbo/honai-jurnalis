<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Comment;
use Livewire\Component;

class ArticleShow extends Component
{
    public Article $article;

    // Form komentar
    public string $guestName  = '';
    public string $guestEmail = '';
    public string $body       = '';
    public bool   $submitted  = false;

    public function mount(Article $article): void
    {
        // Tambah view count tiap artikel dibuka
        $article->incrementViews();
        $this->article = $article;
    }

    // Validasi & simpan komentar
    public function submitComment(): void
    {
        $rules = [
            'body' => 'required|min:5|max:1000',
        ];

        // Kalau belum login, wajib isi nama
        if (!auth()->check()) {
            $rules['guestName']  = 'required|min:2|max:100';
            $rules['guestEmail'] = 'nullable|email|max:100';
        }

        $this->validate($rules, [
            'body.required'         => 'Komentar tidak boleh kosong.',
            'body.min'              => 'Komentar minimal 5 karakter.',
            'guestName.required'    => 'Nama wajib diisi.',
            'guestName.min'         => 'Nama minimal 2 karakter.',
            'guestEmail.email'      => 'Format email tidak valid.',
        ]);

        Comment::create([
            'article_id'  => $this->article->id,
            'user_id'     => auth()->id(),
            'guest_name'  => auth()->check() ? null : $this->guestName,
            'guest_email' => auth()->check() ? null : $this->guestEmail,
            'body'        => $this->body,
            'is_approved' => false, // perlu disetujui editor/admin dulu
        ]);

        // Reset form
        $this->guestName  = '';
        $this->guestEmail = '';
        $this->body       = '';
        $this->submitted  = true;
    }

    public function render()
    {
        // Ambil komentar yang sudah disetujui saja
        $comments = $this->article->comments()
            ->where('is_approved', true)
            ->latest()
            ->get();

        // Artikel terkait (kategori sama, bukan artikel ini sendiri)
        $related = Article::published()
            ->where('category_id', $this->article->category_id)
            ->where('id', '!=', $this->article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('livewire.article-show', [
            'comments' => $comments,
            'related'  => $related,
        ])->layout('layouts.app', [
            'title' => $this->article->title . ' — Honai Jurnalis Kampung',
        ]);
    }

    public function share(string $platform): void
    {
        $this->article->increment('shares');
    }
}
