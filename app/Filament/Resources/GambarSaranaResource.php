<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\GambarSarana;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GambarSaranaResource\Pages;
use App\Filament\Resources\GambarSaranaResource\RelationManagers;

class GambarSaranaResource extends Resource
{
    protected static ?string $model = GambarSarana::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function getNavigationLabel(): string
    {
        return 'Gambar Sarana';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Profil Sekolah';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Select::make('sarana_id')
                            ->label('Sarana')
                            ->relationship('sarana', 'namasarana')
                            ->required(),
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar')
                            ->image()
                            ->maxSize(2048) // 2MB
                            ->preserveFilenames()
                            ->directory('gambar_sarana')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                            ->required(),
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul')
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sarana.namasarana')
                    ->label('Sarana')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular()
                    ->size(50),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListGambarSaranas::route('/'),
            'create' => Pages\CreateGambarSarana::route('/create'),
            'edit' => Pages\EditGambarSarana::route('/{record}/edit'),
        ];
    }
}
