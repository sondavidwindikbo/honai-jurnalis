<?php

namespace App\Filament\Editor\Resources\ArticleResource\Pages;

use App\Filament\Editor\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
