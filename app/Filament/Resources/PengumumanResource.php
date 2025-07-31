<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pengumuman;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengumumanResource\Pages;
use App\Filament\Resources\PengumumanResource\RelationManagers;
use Filament\Forms\Components\Card;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function getNavigationLabel(): string
    {
        return 'Pengumuman';
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
                    Forms\Components\TextInput::make('nama_pengumumen')
                        ->label('Nama Pengumuman')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('file_pengumumen')
                        ->label('File Pengumuman')
                        ->directory('pengumuman-files')
                        ->preserveFilenames()
                        ->visibility('public')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->placeholder('Upload file pengumuman (PDF, DOC, DOCX)')
                        ->maxSize(1024 * 5) // 5 MB
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pengumumen')
                    ->label('Nama Pengumuman')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('file_pengumumen')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => $state ? basename($state) : 'Tidak ada file')
                    ->url(fn ($record) => $record->file_pengumumen ? asset('storage/' . $record->file_pengumumen) : null)
                    ->html()
                    ->sortable(),
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
            'index' => Pages\ListPengumumen::route('/'),
            'create' => Pages\CreatePengumuman::route('/create'),
            'edit' => Pages\EditPengumuman::route('/{record}/edit'),
        ];
    }
}
