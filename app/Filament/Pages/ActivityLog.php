<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Log Aktivitas';
    protected static ?string $navigationGroup = 'Sistem';
    protected static string  $view            = 'filament.pages.activity-log';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public function getLogs()
    {
        return Activity::with('causer')
            ->latest()
            ->limit(100)
            ->get();
    }
}
