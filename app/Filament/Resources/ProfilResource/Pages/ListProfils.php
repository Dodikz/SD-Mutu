<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProfilResource;
use App\Models\Profil;

class ListProfils extends ListRecords
{
    protected static string $resource = ProfilResource::class;
    protected static ?string $title = 'Profil Sekolah';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Profil Sekolah';


    protected function getHeaderActions(): array
    {
        $profil = Profil::first();

        return [
            \Filament\Actions\Action::make('manageProfile')
                ->label($profil ? 'Ubah Profil Sekolah' : 'Tambah Profil Sekolah')
                ->icon($profil ? 'heroicon-o-pencil-square' : 'heroicon-o-plus')
                ->url(function () use ($profil) {
                    return $profil
                        ? route('filament.superadmin.resources.profils.edit', ['record' => $profil->id])
                        : route('filament.superadmin.resources.profils.create');
                })
                ->color('primary'),
        ];
    }
}
