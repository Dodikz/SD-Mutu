<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Testimoni;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TestimoniResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestimoniResource\RelationManagers;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

    protected static ?string $pluralLabel = 'Testimoni';

    public static function getNavigationLabel(): string
    {
        return 'Testimoni';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Testimoni';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('penulis')->columnSpan('full'),
                    Textarea::make('isi_testimoni')->columnSpan('full'),
                    Hidden::make('status')
                        ->default('1')

                ])->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                    '2xl' => 2,
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('isi_testimoni')->searchable()->sortable(),
                TextColumn::make('penulis')->searchable()->sortable(),
                ToggleColumn::make('status'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle('Testimoni berhasil dihapus.')
                    ->modalHeading('Hapus Testimoni')
                    ->modalSubheading('Anda yakin ingin menghapus testimoni yang dipilih? Ini tidak bisa dibatalkan.')
                    ->modalButton('Hapus')
                    ->modalCancelAction('Batalkan')
                    ->action(fn($records) => $records->each(fn(Testimoni $record) => $record->delete()))
                    ->deselectRecordsAfterCompletion()
                    ->label('Hapus testimoni yang dipilih'),
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
            'index' => Pages\ListTestimonis::route('/'),
            'create' => Pages\CreateTestimoni::route('/create'),
            'edit' => Pages\EditTestimoni::route('/{record}/edit'),
        ];
    }
}
