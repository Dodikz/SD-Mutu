<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProfilResource;
use App\Models\Profil;

class ListProfils extends ListRecords
{
    protected static string $resource = ProfilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('editProfile')
                ->label('Ubah Profil Sekolah')
                ->icon('heroicon-o-pencil-square')
                ->url(fn () => route('filament.superadmin.resources.profils.edit', ['record' => Profil::first()?->id]))
                ->color('primary'),
        ];
    }
}
