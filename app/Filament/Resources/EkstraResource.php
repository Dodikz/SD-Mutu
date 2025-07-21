<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EkstraResource\Pages;
use App\Filament\Resources\EkstraResource\RelationManagers;
use App\Models\Ektra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EkstraResource extends Resource
{
    protected static ?string $model = Ektra::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    public static function getNavigationLabel(): string
    {
        return 'Ekstrakurikuler';
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
            'index' => Pages\ListEkstras::route('/'),
            'create' => Pages\CreateEkstra::route('/create'),
            'edit' => Pages\EditEkstra::route('/{record}/edit'),
        ];
    }
}
