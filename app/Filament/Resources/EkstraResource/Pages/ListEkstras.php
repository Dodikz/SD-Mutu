<?php

namespace App\Filament\Resources\EkstraResource\Pages;

use App\Filament\Resources\EkstraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEkstras extends ListRecords
{
    protected static string $resource = EkstraResource::class;

    protected static ?string $title = 'Daftar Ekstrakurikuler';
    
    public function getBreadcrumb(): ?string
    {
        return 'Daftar Ekstrakurikuler';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('Tambah Ekstrakurikuler')
                ->icon('heroicon-o-plus')
                ->label('Tambah Ekstrakurikuler'),
        ];
    }
}
