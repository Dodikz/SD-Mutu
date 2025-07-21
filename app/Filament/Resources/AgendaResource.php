<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Agenda;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\AgendaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AgendaResource\Pages\EditAgenda;
use App\Filament\Resources\AgendaResource\RelationManagers;
use App\Filament\Resources\AgendaResource\Pages\ListAgendas;
use App\Filament\Resources\AgendaResource\Pages\CreateAgenda;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\Modal\Actions\Action;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;

class AgendaResource extends Resource
{
    protected static ?string $model = Agenda::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function getNavigationLabel(): string
    {
        return 'Agenda';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Konten Website';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul_agenda')
                    ->required('Judul agenda harus diisi')
                    ->maxLength(100, 'Judul agenda tidak boleh lebih dari 100 karakter'),
                TextInput::make('lokasi_agenda')
                    ->required('Lokasi agenda harus diisi')
                    ->maxLength(100, 'Lokasi agenda tidak boleh lebih dari 100 karakter'),
                TimePicker::make('jam_mulai_agenda')
                    ->required('Jam mulai agenda harus diisi')
                    ->default(now()->setTimezone('Asia/Jakarta')),
                TimePicker::make('jam_selesai_agenda')
                    ->required('Jam selesai agenda harus diisi')
                    ->default(now()->setTimezone('Asia/Jakarta'))
                    ->after('jam_mulai_agenda')
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $jamMulai = $get('jam_mulai_agenda');

                        if ($jamMulai && $state <= $jamMulai) {
                            $set('jam_selesai_agenda', null);
                            return 'Jam selesai harus setelah jam mulai.'; 
                        }
                    }),
                DatePicker::make('tanggal_agenda')
                    ->required('Tanggal agenda harus diisi')
                    ->default(now()->setTimezone('Asia/Jakarta'))
                    ->minDate(now()->setTimezone('Asia/Jakarta'))
                    ->maxDate(now()->addYear()->setTimezone('Asia/Jakarta'))
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state < now()->setTimezone('Asia/Jakarta')->format('Y-m-d')) {
                            $set('tanggal_agenda', null);
                            return 'Tanggal agenda tidak boleh di masa lalu.';
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul_agenda')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lokasi_agenda'),
                TextColumn::make('jam_mulai_agenda')
                    ->label('Jam Mulai')
                    ->timezone('Asia/Jakarta')
                    ->dateTime('H:i'),
                TextColumn::make('jam_selesai_agenda')
                    ->label('Jam Selesai')
                    ->timezone('Asia/Jakarta')
                    ->dateTime('H:i'),
                TextColumn::make('tanggal_agenda')
                    ->date()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('tanggal_agenda')
                    ->label('Tanggal Agenda')
                    ->options(Agenda::pluck('tanggal_agenda')->unique()->mapWithKeys(fn($date) => [$date => $date])),
            ])
            ->actions([
                    EditAction::make(),
                    DeleteAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Agenda')
                        ->modalSubheading('Anda yakin ingin menghapus agenda ini? Ini tidak bisa dibatalkan.')
                        ->action(fn(Agenda $record) => $record->delete())
                        ->successNotificationTitle('Agenda berhasil dihapus!'),
            ])
            ->bulkActions([
                    DeleteBulkAction::make()
                        ->requiresConfirmation('Anda yakin ingin menghapus agenda yang dipilih?')
                        ->modalHeading('Hapus Agenda')
                        ->modalSubheading('Anda yakin ingin menghapus agenda yang dipilih? Ini tidak bisa dibatalkan.')
                        ->action(fn(Collection $records) => $records->each->delete())
                        ->label('Hapus Terpilih')
                        ->successNotificationTitle('Agenda berhasil dihapus!'),
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
            'index' => Pages\ListAgendas::route('/'),
            'create' => Pages\CreateAgenda::route('/create'),
            'edit' => Pages\EditAgenda::route('/{record}/edit'),
        ];
    }
}
