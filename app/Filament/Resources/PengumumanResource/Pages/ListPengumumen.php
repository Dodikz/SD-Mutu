<?php

namespace App\Filament\Resources\PengumumanResource\Pages;

use App\Filament\Resources\PengumumanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengumumen extends ListRecords
{
    protected static string $resource = PengumumanResource::class;
    protected static ?string $title = 'Daftar Pengumuman';
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?string $navigationLabel = 'Pengumuman';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Pengumuman')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->form([
                    'nama_pengumumen' => 'Nama Pengumuman',
                    'file_pengumumen' => 'File Pengumuman',
                ]),
        ];
    }
}
