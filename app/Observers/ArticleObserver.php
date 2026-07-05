<?php

namespace App\Observers;

use App\Mail\ArticleStatusMail;
use App\Models\Article;
use App\Models\User;
use App\Notifications\ArticleNotification;
use Illuminate\Support\Facades\Mail;

class ArticleObserver
{
    public function updated(Article $article): void
    {
        if (! $article->wasChanged('status')) return;

        $oldStatus = $article->getOriginal('status');
        $newStatus = $article->status;
        $penulis   = $article->user;
        $editors   = User::where('role', 'editor')->where('is_active', true)->get();
        $admins    = User::where('role', 'admin')->where('is_active', true)->get();

        // ── DRAFT → PENDING ──────────────────────────────────────────
        if ($oldStatus === 'draft' && $newStatus === 'pending') {

            // 🔔 Notif bell ke penulis
            $penulis->notify(new ArticleNotification(
                title: 'Artikel berhasil dikirim',
                body:  "Artikel \"{$article->title}\" sedang menunggu review editor.",
                color: 'success',
                icon:  'heroicon-o-paper-airplane',
                url:   "/penulis/articles/{$article->id}/edit",
            ));

            foreach ($editors as $editor) {
                // 🔔 Notif bell ke editor
                $editor->notify(new ArticleNotification(
                    title: 'Artikel baru menunggu review',
                    body:  "{$penulis->name} mengirim \"{$article->title}\".",
                    color: 'warning',
                    icon:  'heroicon-o-document-text',
                    url:   "/editor/articles/{$article->id}/edit",
                ));

                // 📧 Email ke editor
                Mail::to($editor->email)
                    ->send(new ArticleStatusMail($article, 'submitted', 'editor'));
            }

            foreach ($admins as $admin) {
                // 🔔 Notif bell ke admin (monitoring)
                $admin->notify(new ArticleNotification(
                    title: 'Artikel baru dikirim penulis',
                    body:  "{$penulis->name}: \"{$article->title}\" menunggu review.",
                    color: 'info',
                    icon:  'heroicon-o-bell',
                ));
            }
        }

        // ── PENDING → PUBLISHED ──────────────────────────────────────
        if ($oldStatus === 'pending' && $newStatus === 'published') {

            // 🔔 Notif bell ke penulis
            $penulis->notify(new ArticleNotification(
                title: 'Artikel berhasil diterbitkan!',
                body:  "Artikel \"{$article->title}\" sudah tayang di website.",
                color: 'success',
                icon:  'heroicon-o-check-circle',
                url:   route('article.show', $article->slug),
            ));

            // 📧 Email ke penulis
            Mail::to($penulis->email)
                ->send(new ArticleStatusMail($article, 'published', 'penulis'));

            foreach ($admins as $admin) {
                // 🔔 Notif bell ke admin
                $admin->notify(new ArticleNotification(
                    title: 'Artikel diterbitkan',
                    body:  "Editor menerbitkan \"{$article->title}\" oleh {$penulis->name}.",
                    color: 'success',
                    icon:  'heroicon-o-check-circle',
                ));
            }
        }

        // ── PENDING → REJECTED ───────────────────────────────────────
        if ($oldStatus === 'pending' && $newStatus === 'rejected') {

            // 🔔 Notif bell ke penulis
            $penulis->notify(new ArticleNotification(
                title: 'Artikel perlu direvisi',
                body:  "Artikel \"{$article->title}\" dikembalikan editor untuk diperbaiki.",
                color: 'danger',
                icon:  'heroicon-o-arrow-uturn-left',
                url:   "/penulis/articles/{$article->id}/edit",
            ));

            // 📧 Email ke penulis
            Mail::to($penulis->email)
                ->send(new ArticleStatusMail($article, 'rejected', 'penulis'));

            foreach ($admins as $admin) {
                $admin->notify(new ArticleNotification(
                    title: 'Artikel ditolak editor',
                    body:  "Editor mengembalikan \"{$article->title}\" ke {$penulis->name}.",
                    color: 'danger',
                    icon:  'heroicon-o-x-circle',
                ));
            }
        }

        // ── REJECTED → PENDING ───────────────────────────────────────
        if ($oldStatus === 'rejected' && $newStatus === 'pending') {

            foreach ($editors as $editor) {
                // 🔔 Notif bell ke editor
                $editor->notify(new ArticleNotification(
                    title: 'Revisi artikel dikirim ulang',
                    body:  "{$penulis->name} mengirim ulang revisi \"{$article->title}\".",
                    color: 'warning',
                    icon:  'heroicon-o-arrow-path',
                    url:   "/editor/articles/{$article->id}/edit",
                ));

                // 📧 Email ke editor
                Mail::to($editor->email)
                    ->send(new ArticleStatusMail($article, 'revision', 'editor'));
            }
        }
    }
}
