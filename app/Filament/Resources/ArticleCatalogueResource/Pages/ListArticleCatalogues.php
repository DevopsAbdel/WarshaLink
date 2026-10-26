<?php

namespace App\Filament\Resources\ArticleCatalogueResource\Pages;

use App\Filament\Resources\ArticleCatalogueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticleCatalogues extends ListRecords
{
    protected static string $resource = ArticleCatalogueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
