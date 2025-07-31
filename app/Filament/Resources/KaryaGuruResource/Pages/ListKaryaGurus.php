<?php

namespace App\Filament\Resources\KaryaGuruResource\Pages;

use App\Filament\Resources\KaryaGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKaryaGurus extends ListRecords
{
    protected static string $resource = KaryaGuruResource::class;
    protected static ?string $title = 'Karya Guru';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Kegiatan & Prestasi';
    protected static ?string $navigationLabel = 'Karya Guru';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Karya Guru')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
