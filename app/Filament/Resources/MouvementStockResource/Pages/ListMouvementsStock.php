<?php

namespace App\Filament\Resources\MouvementStockResource\Pages;

use App\Filament\Resources\MouvementStockResource;
use Filament\Resources\Pages\ListRecords;

class ListMouvementsStock extends ListRecords
{
    protected static string $resource = MouvementStockResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
