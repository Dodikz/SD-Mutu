<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryaGuruResource\Pages;
use App\Filament\Resources\KaryaGuruResource\RelationManagers;
use App\Models\KaryaGuru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaryaGuruResource extends Resource
{
    protected static ?string $model = KaryaGuru::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function getNavigationLabel(): string
    {
        return 'Karya Guru';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Kegiatan & Prestasi';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKaryaGurus::route('/'),
            'create' => Pages\CreateKaryaGuru::route('/create'),
            'edit' => Pages\EditKaryaGuru::route('/{record}/edit'),
        ];
    }
}
