<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Daftar User';

    public function getBreadcrumb(): ?string
    {
        return 'Daftar User';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah User')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
