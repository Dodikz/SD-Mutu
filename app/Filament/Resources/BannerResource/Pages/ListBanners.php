<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;
    protected static ?string $title = 'Daftar Banner';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Konten Website'; 

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Banner')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Tambah Banner Baru'),
        ];
    }
}
