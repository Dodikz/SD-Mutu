<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaranaResource\Pages;
use App\Filament\Resources\SaranaResource\RelationManagers;
use App\Models\Sarana;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaranaResource extends Resource
{
    protected static ?string $model = Sarana::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

        public static function getNavigationLabel(): string
    {
        return 'Sarana & Prasarana';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Profil Sekolah';
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
            'index' => Pages\ListSaranas::route('/'),
            'create' => Pages\CreateSarana::route('/create'),
            'edit' => Pages\EditSarana::route('/{record}/edit'),
        ];
    }
}
