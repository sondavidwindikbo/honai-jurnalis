<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class AdminArticleChart extends ChartWidget
{
    protected static ?string $heading = 'Aktivitas Artikel';
    protected static ?int    $sort    = 2;

    public ?string $filter = '7';

    protected function getFilters(): ?array
    {
        return [
            '7'  => '7 Hari Terakhir',
            '30' => '30 Hari Terakhir',
        ];
    }

    protected function getData(): array
    {
        $days  = (int) ($this->filter ?? 7);
        $start = now()->subDays($days - 1)->startOfDay();

        $labels   = [];
        $dikirim  = [];
        $publish  = [];
        $ditolak  = [];

        for ($i = 0; $i < $days; $i++) {
            $date       = $start->copy()->addDays($i);
            $labels[]   = $date->format('d M');
            $dikirim[]  = Article::where('status','pending')
                ->whereDate('updated_at', $date)->count();
            $publish[]  = Article::where('status','published')
                ->whereDate('published_at', $date)->count();
            $ditolak[]  = Article::where('status','rejected')
                ->whereDate('updated_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Dikirim',
                    'data'            => $dikirim,
                    'borderColor'     => '#3B82F6',
                    'backgroundColor' => 'rgba(59,130,246,0.1)',
                    'tension'         => 0.4,
                    'fill'            => true,
                ],
                [
                    'label'           => 'Dipublish',
                    'data'            => $publish,
                    'borderColor'     => '#10B981',
                    'backgroundColor' => 'rgba(16,185,129,0.1)',
                    'tension'         => 0.4,
                    'fill'            => true,
                ],
                [
                    'label'           => 'Ditolak',
                    'data'            => $ditolak,
                    'borderColor'     => '#EF4444',
                    'backgroundColor' => 'rgba(239,68,68,0.1)',
                    'tension'         => 0.4,
                    'fill'            => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
