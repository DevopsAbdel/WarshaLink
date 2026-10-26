<?php

namespace App\Filament\Resources\DemandeAchatResource\Pages;

use App\Filament\Resources\DemandeAchatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemandeAchats extends ListRecords
{
    protected static string $resource = DemandeAchatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
