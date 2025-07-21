<?php

namespace App\Filament\Resources\EkstraResource\Pages;

use App\Filament\Resources\EkstraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEkstra extends EditRecord
{
    protected static string $resource = EkstraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
