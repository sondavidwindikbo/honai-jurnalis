<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ArticleStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Article $article,
        public string  $type,      // 'submitted' | 'published' | 'rejected' | 'revision'
        public string  $recipient, // 'penulis' | 'editor'
    ) {}

    public function envelope(): Envelope
    {
        $subjects = [
            'submitted' => '📨 Artikel Baru Menunggu Review',
            'published' => '🎉 Artikel Kamu Berhasil Diterbitkan!',
            'rejected'  => '📝 Artikel Perlu Direvisi',
            'revision'  => '🔄 Revisi Artikel Dikirim Ulang',
        ];

        return new Envelope(
            subject: $subjects[$this->type] ?? 'Notifikasi Artikel'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.article-status',
        );
    }
}
