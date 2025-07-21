<?php

namespace App\Filament\Resources\KaryaGuruResource\Pages;

use App\Filament\Resources\KaryaGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKaryaGuru extends EditRecord
{
    protected static string $resource = KaryaGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
