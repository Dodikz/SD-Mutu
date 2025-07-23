<?php

namespace App\Filament\Resources\SaranaResource\Pages;

use App\Filament\Resources\SaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaranas extends ListRecords
{
    protected static string $resource = SaranaResource::class;
    protected static ?string $title = 'Sarana & Prasarana';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah Sarana & Prasarana')
                ->color('primary')
                ->tooltip('Tambah Sarana Baru'),
        ];
    }
}
