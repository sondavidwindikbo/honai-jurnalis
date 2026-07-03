<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        // Cek kalau status berubah
        if (! $article->wasChanged('status')) return;

        $oldStatus = $article->getOriginal('status');
        $newStatus = $article->status;
        $penulis   = $article->user;

        // Penulis submit artikel (draft → pending)
        if ($oldStatus === 'draft' && $newStatus === 'pending') {

            // Notifikasi ke penulis sendiri
            Notification::make()
                ->title('Artikel berhasil dikirim')
                ->body("Artikel \"{$article->title}\" menunggu proses review.")
                ->success()
                ->sendToDatabase($penulis);

            // Notifikasi ke semua editor
            $editors = User::where('role', 'editor')->get();
            foreach ($editors as $editor) {
                Notification::make()
                    ->title('Artikel baru menunggu review')
                    ->body("Artikel dari {$penulis->name}: \"{$article->title}\".")
                    ->warning()
                    ->actions([
                        Action::make('review')
                            ->label('Review Sekarang')
                            ->url("/admin/articles/{$article->id}/edit"),
                    ])
                    ->sendToDatabase($editor);
            }
        }

        // Editor approve artikel (pending → published)
        if ($oldStatus === 'pending' && $newStatus === 'published') {
            Notification::make()
                ->title('Artikel kamu diterbitkan! 🎉')
                ->body("Artikel \"{$article->title}\" sudah tayang di website.")
                ->success()
                ->sendToDatabase($penulis);
        }

        // Editor reject artikel (pending → rejected)
        if ($oldStatus === 'pending' && $newStatus === 'rejected') {
            Notification::make()
                ->title('Artikel memerlukan revisi')
                ->body("Artikel \"{$article->title}\" dikembalikan untuk diperbaiki.")
                ->danger()
                ->sendToDatabase($penulis);
        }
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
