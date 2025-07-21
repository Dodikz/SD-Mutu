<?php

namespace App\Filament\Resources\KaryaGuruResource\Pages;

use App\Filament\Resources\KaryaGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKaryaGurus extends ListRecords
{
    protected static string $resource = KaryaGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
