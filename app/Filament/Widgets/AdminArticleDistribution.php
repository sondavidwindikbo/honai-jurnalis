<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class AdminArticleDistribution extends ChartWidget
{
    protected static ?string $heading   = 'Distribusi Artikel';
    protected static ?int    $sort      = 3;
    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $published = Article::where('status','published')->count();
        $pending   = Article::where('status','pending')->count();
        $draft     = Article::where('status','draft')->count();
        $rejected  = Article::where('status','rejected')->count();

        return [
            'datasets' => [[
                'data'            => [$published, $pending, $draft, $rejected],
                'backgroundColor' => ['#10B981','#F59E0B','#6B7280','#EF4444'],
                'hoverOffset'     => 4,
            ]],
            'labels' => [
                "Tayang ({$published})",
                "Review ({$pending})",
                "Draft ({$draft})",
                "Ditolak ({$rejected})",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
