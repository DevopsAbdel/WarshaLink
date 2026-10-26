<?php

namespace App\Filament\Resources\PointageResource\Pages;

use App\Filament\Resources\PointageResource;
use App\Models\Pointage;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePointage extends CreateRecord
{
    protected static string $resource = PointageResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $dateFormatted = Carbon::parse($data['date_pointage'])->format('Y-m-d');
        $data['date_pointage'] = $dateFormatted;

        $existing = Pointage::where('chantier_id', $data['chantier_id'])
            ->where('employe_id', $data['employe_id'])
            ->whereDate('date_pointage', $dateFormatted)
            ->first();

        if ($existing) {
            $existing->update($data);

            Notification::make()
                ->title('Pointage mis à jour')
                ->body('Cet ouvrier était déjà enregistré pour cette date. Sa fiche de présence a été actualisée.')
                ->warning()
                ->send();

            return $existing;
        }

        return static::getModel()::create($data);
    }
}
