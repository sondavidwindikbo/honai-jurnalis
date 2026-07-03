<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        if ($user->role === 'penulis') {
            return [
                Stat::make('Artikel Saya', Article::where('user_id', $user->id)->count())
                    ->description('Total artikel yang pernah ditulis')
                    ->color('success')
                    ->icon('heroicon-o-newspaper'),

                Stat::make('Diterbitkan', Article::where('user_id', $user->id)->where('status', 'published')->count())
                    ->description('Artikel yang sudah tayang')
                    ->color('primary')
                    ->icon('heroicon-o-check-circle'),

                Stat::make('Menunggu Review', Article::where('user_id', $user->id)->where('status', 'pending')->count())
                    ->description('Sedang diproses editor')
                    ->color('warning')
                    ->icon('heroicon-o-clock'),

                Stat::make('Total Dibaca', Article::where('user_id', $user->id)->sum('views'))
                    ->description('Total pembaca semua artikelmu')
                    ->color('info')
                    ->icon('heroicon-o-eye'),
            ];
        }

        // Admin & Editor: statistik global
        return [
            Stat::make('Total Artikel', Article::published()->count())
                ->description('Artikel yang sudah tayang')
                ->color('success')
                ->icon('heroicon-o-newspaper'),

            Stat::make('Menunggu Review', Article::where('status', 'pending')->count())
                ->description('Perlu direview editor')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make('Total Penulis', User::where('role', 'penulis')->where('is_active', true)->count())
                ->description('Penulis aktif')
                ->color('primary')
                ->icon('heroicon-o-users'),

            Stat::make('Total Komentar', Comment::where('is_approved', true)->count())
                ->description('Komentar yang sudah disetujui')
                ->color('info')
                ->icon('heroicon-o-chat-bubble-left-right'),
        ];
    }
}
