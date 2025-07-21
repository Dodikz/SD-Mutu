<?php

namespace App\Filament\Resources\GambarSaranaResource\Pages;

use App\Filament\Resources\GambarSaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGambarSaranas extends ListRecords
{
    protected static string $resource = GambarSaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
