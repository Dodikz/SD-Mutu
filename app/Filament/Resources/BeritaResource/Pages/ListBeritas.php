<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use App\Filament\Resources\BeritaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBeritas extends ListRecords
{
    protected static string $resource = BeritaResource::class;
    protected static ?string $title = 'Daftar Berita';
    public function getBreadcrumb(): ?string
    {
        return 'Daftar Berita';
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Berita')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
