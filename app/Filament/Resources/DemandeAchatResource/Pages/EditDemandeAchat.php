<?php

namespace App\Filament\Resources\DemandeAchatResource\Pages;

use App\Filament\Resources\DemandeAchatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDemandeAchat extends EditRecord
{
    protected static string $resource = DemandeAchatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
