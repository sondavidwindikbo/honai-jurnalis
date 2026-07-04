<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string  $title,
        public string  $body,
        public string  $color  = 'primary',
        public string  $icon   = 'heroicon-o-bell',
        public ?string $url    = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

      public function toDatabase(object $notifiable): array
        {
            return [
                'title' => $this->title,
                'body'  => $this->body,
                'color' => $this->color,
                'icon'  => $this->icon,
                'url'   => $this->url,

                // WAJIB untuk Filament v3.3.54
                'format' => 'filament',
                'duration' => 'persistent',
            ];
        }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
