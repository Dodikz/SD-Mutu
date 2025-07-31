<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\KaryaGuru;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KaryaGuruResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KaryaGuruResource\RelationManagers;
use Filament\Tables\Actions\ViewAction;

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
                Card::make([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('nama_karya_guru')
                                ->label('Nama Karya Guru')
                                ->required()
                                ->afterStateUpdated(
                                    fn($state, callable $set) =>
                                    $set('slug', \Illuminate\Support\Str::slug($state))
                                )
                                ->columnSpan(1),
                            Select::make('user_id')
                                ->label('nama guru')
                                ->options(
                                    fn() => User::pluck('name', 'id')
                                )
                                ->searchable()
                                ->required(),
                            Hidden::make('slug'),
                            FileUpload::make('foto_karya_guru')
                                ->label('Foto Karya Guru')
                                ->image()
                                ->required()
                                ->columnSpan(1),
                            RichEditor::make('isi_karya')
                                ->label('Isi Karya')
                                ->required()
                                ->columnSpan(1),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_karya_guru')
                    ->label('Nama Karya Guru')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('foto_karya_guru')
                    ->label('Foto Karya Guru'),
                TextColumn::make('user.name')
                    ->label('Nama Guru')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('isi_karya')
                    ->label('Isi Karya')
                    ->limit(50)
                    ->html()
                    ->searchable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
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
