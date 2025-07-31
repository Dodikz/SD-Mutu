<?php

namespace App\Filament\Resources\GambarSaranaResource\Pages;

use App\Filament\Resources\GambarSaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGambarSaranas extends ListRecords
{
    protected static string $resource = GambarSaranaResource::class;
    protected static ?string $title = 'Daftar Gambar Sarana';
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Profil Sekolah';
    protected static ?string $navigationLabel = 'Gambar Sarana';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Gambar Sarana')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Tambah Gambar Sarana Baru'),
        ];
    }
}
