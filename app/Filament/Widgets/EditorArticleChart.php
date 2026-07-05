<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class EditorArticleChart extends ChartWidget
{
    protected static ?string $heading = 'Ringkasan Aktivitas Review';
    protected static ?int    $sort    = 2;

    public ?string $filter = '7';

    protected function getFilters(): ?array
    {
        return [
            '7'  => '7 Hari Terakhir',
            '30' => '30 Hari',
        ];
    }

    protected function getData(): array
    {
        $days  = (int) ($this->filter ?? 7);
        $start = now()->subDays($days - 1)->startOfDay();

        $labels     = [];
        $direview   = [];
        $disetujui  = [];
        $ditolak    = [];

        for ($i = 0; $i < $days; $i++) {
            $date        = $start->copy()->addDays($i);
            $labels[]    = $date->format('d M');
            $direview[]  = Article::where('status','pending')
                ->whereDate('updated_at', $date)->count();
            $disetujui[] = Article::where('status','published')
                ->whereDate('published_at', $date)->count();
            $ditolak[]   = Article::where('status','rejected')
                ->whereDate('updated_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label'       => 'Direview',
                    'data'        => $direview,
                    'borderColor' => '#F59E0B',
                    'tension'     => 0.4,
                ],
                [
                    'label'       => 'Disetujui',
                    'data'        => $disetujui,
                    'borderColor' => '#10B981',
                    'tension'     => 0.4,
                ],
                [
                    'label'       => 'Ditolak',
                    'data'        => $ditolak,
                    'borderColor' => '#EF4444',
                    'tension'     => 0.4,
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
