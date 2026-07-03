<?php

namespace App\Filament\Penulis\Resources\ArticleResource\Pages;

use App\Filament\Penulis\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
