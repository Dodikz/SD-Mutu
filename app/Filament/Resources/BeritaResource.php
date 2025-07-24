<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Berita;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BeritaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BeritaResource\RelationManagers;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $pluralLabel = 'Berita';
    public static function getNavigationLabel(): string
    {
        return 'Berita';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Konten Website';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Grid::make(12)
                        ->schema([
                            TextInput::make('judul_berita')
                                ->label('Judul Berita')
                                ->afterStateUpdated(
                                    fn($state, callable $set) =>
                                    $set('slug', Str::slug($state))
                                )
                                ->required()
                                ->columnSpan(4),

                            Hidden::make('slug'),

                            FileUpload::make('gambar_berita')
                                ->label('Gambar Berita')
                                ->image() 
                                ->nullable()
                                ->disk('public')
                                ->directory('berita')
                                ->preserveFilenames()
                                ->maxSize(2048)
                                ->columnSpan(8),

                            Select::make('user_id')
                                ->label('Penulis')
                                ->options(
                                    fn() => User::pluck('name', 'id')
                                )
                                ->searchable()
                                ->required()
                                ->columnSpanFull(),

                            RichEditor::make('isi_berita')
                                ->label('Isi Berita')
                                ->required()
                                ->columnSpanFull(),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul_berita')
                    ->label('Judul Berita')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gambar_berita')
                    ->label('Gambar Berita')
                    ->formatStateUsing(fn($state) => $state ? '<img src="' . asset('storage/' . $state) . '" alt="Gambar Berita" style="max-width: 100px; max-height: 100px;">' : 'Tidak ada gambar')
                    ->html(),
                TextColumn::make('isi_berita')
                    ->label('Isi Berita')
                    ->limit(50)
                    ->searchable()
                    ->sortable()
                    ->html(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
