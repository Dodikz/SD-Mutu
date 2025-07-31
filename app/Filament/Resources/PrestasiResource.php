<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Prestasi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PrestasiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PrestasiResource\RelationManagers;
use Filament\Forms\Components\Textarea;

class PrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $pluralLabel = 'Prestasi';

    public static function getNavigationLabel(): string
    {
        return 'Prestasi';
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
                    FileUpload::make('gambar_prestasi')
                        ->directory('prestasi-images')
                        ->image()
                        ->maxSize(2048) 
                        ->preserveFilenames()
                        ->directory('prestasi')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                        ->required(),
                    Select::make('jenis_prestasi')
                        ->options([
                            'Akademik' => 'Akademik',
                            'Non Akademik' => 'Non Akademik',
                        ])
                        ->required(),
                    TextInput::make('nama_prestasi')
                        ->maxLength(50)
                        ->required(),
                    Textarea::make('keterangan_prestasi')
                        ->maxLength(100),
                    TextInput::make('penyelenggara')
                        ->maxLength(50)
                        ->required(),
                    TextInput::make('peringkat')
                        ->maxLength(50)
                        ->required(),
                    TextInput::make('bidang')
                        ->maxLength(50)
                        ->required(),
                ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 3,
                        '2xl' => 3,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis_prestasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_prestasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('keterangan_prestasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('penyelenggara')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('peringkat')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bidang')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('gambar_prestasi')
                    ->label('Gambar Prestasi'),
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
            'index' => Pages\ListPrestasis::route('/'),
            'create' => Pages\CreatePrestasi::route('/create'),
            'edit' => Pages\EditPrestasi::route('/{record}/edit'),
        ];
    }
}
