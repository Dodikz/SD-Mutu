<?php

namespace App\Filament\Resources\PrestasiResource\Pages;

use App\Filament\Resources\PrestasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrestasis extends ListRecords
{
    protected static string $resource = PrestasiResource::class;
    protected static ?string $title = 'Daftar Prestasi';
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Kegiatan & Prestasi';
    protected static ?string $navigationLabel = 'Prestasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Prestasi')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Tambah Prestasi Baru')
                ->modalButton('Simpan Prestasi'),
        ];
    }
}
