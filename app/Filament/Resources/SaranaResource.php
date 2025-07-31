<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sarana;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Date;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SaranaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaranaResource\RelationManagers;

class SaranaResource extends Resource
{
    protected static ?string $model = Sarana::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $pluralLabel = 'Sarana & Prasarana';

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
                Card::make([
                    TextInput::make('namasarana')
                        ->label('Nama Sarana')
                        ->maxLength(50),
                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->rows(3)
                        ->maxLength(1000),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('namasarana')
                    ->label('Nama Sarana')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
            ])

            ->filters([
                Filter::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->form([
                        DatePicker::make('start_date')->label('Dari Tanggal'),
                        DatePicker::make('end_date')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start_date'], fn($q) => $q->whereDate('created_at', '>=', $data['start_date']))
                            ->when($data['end_date'], fn($q) => $q->whereDate('created_at', '<=', $data['end_date']));
                    }),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            
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
