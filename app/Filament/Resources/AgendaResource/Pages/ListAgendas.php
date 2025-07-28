<?php

namespace App\Filament\Resources\AgendaResource\Pages;

use App\Filament\Resources\AgendaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgendas extends ListRecords
{
    protected static string $resource = AgendaResource::class;
    protected static ?string $title = 'Daftar Agenda';
    



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('Tambah Agenda')
                ->color('primary')
                ->modalHeading('Tambah Agenda Baru')
                ->modalButton('Simpan'),
        ];
    }
}
