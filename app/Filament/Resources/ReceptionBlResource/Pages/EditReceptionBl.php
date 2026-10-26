<?php

namespace App\Filament\Resources\ReceptionBlResource\Pages;

use App\Filament\Resources\ReceptionBlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceptionBl extends EditRecord
{
    protected static string $resource = ReceptionBlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
