<?php

namespace App\Filament\Resources\ChantierResource\Pages;

use App\Filament\Resources\ChantierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChantiers extends ListRecords
{
    protected static string $resource = ChantierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
