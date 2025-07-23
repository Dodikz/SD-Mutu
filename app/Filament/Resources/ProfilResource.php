<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Profil;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\ProfilResource\Pages;
use Filament\Tables\Actions\ViewAction;

class ProfilResource extends Resource
{
    protected static ?string $model = Profil::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationLabel(): string
    {
        return 'Profil Sekolah';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Profil Sekolah';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Tabs::make('Profil Sekolah')
                ->tabs([
                    Tab::make('Identitas')
                    ->icon('heroicon-o-user')
                        ->schema([
                            TextInput::make('kepala_sekolah')
                                ->label('Nama Kepala Sekolah'),

                            FileUpload::make('foto_kepala_sekolah')
                                ->label('Foto Kepala Sekolah')
                                ->image()
                                ->disk('public')
                                ->directory('profil')
                                ->visibility('public')
                                ->preserveFilenames(),

                            Select::make('akreditasi')
                                ->label('Akreditasi')
                                ->options([
                                    'A' => 'A',
                                    'B' => 'B',
                                    'C' => 'C',
                                    'Tidak Terakreditasi' => 'Tidak Terakreditasi',
                                    'Belum Terakreditasi' => 'Belum Terakreditasi',
                                ]),
                        ]),
                    Tab::make('Sambutan')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                        ->schema([
                            RichEditor::make('sambutan_kepala_sekolah')
                                ->label('Sambutan Kepala Sekolah'),
                        ]),
                    Tab::make('Sejarah')
                        ->icon('heroicon-o-book-open')
                        ->schema([
                            RichEditor::make('sejarah')
                                ->label('Sejarah'),
                        ]),
                    Tab::make('Visi')
                        ->icon('heroicon-o-light-bulb')
                        ->schema([
                            RichEditor::make('visi')
                                ->label('Visi'),
                        ]),
                    Tab::make('Misi')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            RichEditor::make('misi')
                                ->label('Misi'),
                        ]),
                ])
                ->columnSpanFull()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kepala_sekolah')
                    ->label('Nama Kepala Sekolah')
                    ->searchable(),

                ImageColumn::make('foto_kepala_sekolah')
                    ->label('Foto'),

                TextColumn::make('sambutan_kepala_sekolah')
                    ->label('Sambutan')
                    ->formatStateUsing(fn ($state) => Str::limit(strip_tags($state), 50)),

                TextColumn::make('sejarah')
                    ->label('Sejarah')
                    ->formatStateUsing(fn ($state) => Str::limit(strip_tags($state), 50)),

                TextColumn::make('visi')
                    ->label('Visi')
                    ->formatStateUsing(fn ($state) => Str::limit(strip_tags($state), 50)),

                TextColumn::make('misi')
                    ->label('Misi')
                    ->formatStateUsing(fn ($state) => Str::limit(strip_tags($state), 50)),

                TextColumn::make('akreditasi')
                    ->label('Akreditasi'),
            ])
            ->actions([
                // EditAction::make(),
                ViewAction::make('view')
                    ->label('Lihat Profil')
                    ->icon('heroicon-o-eye')
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfils::route('/'),
            'create' => Pages\CreateProfil::route('/create'),
            'edit' => Pages\EditProfil::route('/{record}/edit'),
        ];
    }
}
