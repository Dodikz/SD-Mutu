<?php

namespace App\Filament\Resources;

use App\Models\Ektra;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Modal\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\EkstraResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AgendaResource\Pages\EditAgenda;
use App\Filament\Resources\EkstraResource\RelationManagers;
use App\Filament\Resources\AgendaResource\Pages\ListAgendas;
use App\Filament\Resources\AgendaResource\Pages\CreateAgenda;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Card;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;

class EkstraResource extends Resource
{
    protected static ?string $model = Ektra::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $pluralLabel = 'Ekstrakurikuler';

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
                Card::make([
                    FileUpload::make('gambar_ektra')
                    ->label('Foto Ekstrakurikuler')
                    ->image(Notification::make('Gambar ekstrakurikuler harus berupa gambar'))
                    ->disk('public')
                    ->directory('ekstrakurikuler')
                    ->preserveFilenames()
                    ->visibility('public')
                    ->maxSize(2048, 'Ukuran maksimal foto adalah 2MB')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                    ->placeholder('Unggah foto ekstrakurikuler')
                    ->helperText('Unggah foto ekstrakurikuler dalam format JPEG, PNG, atau GIF dengan ukuran maksimal 2MB.'),
                TextInput::make('judul_ektra')
                    ->label('Nama Ekstrakurikuler')
                    ->maxLength(100, 'Nama ekstrakurikuler tidak boleh lebih dari 100 karakter')
                    ->placeholder('Masukkan nama ekstrakurikuler'),
                TextInput::make('pembina')
                    ->label('Nama Pembina')
                    ->maxLength(50, 'Nama pembina tidak boleh lebih dari 100 karakter')
                    ->placeholder('Masukkan nama pembina'),
                Select::make('hari')
                    ->label('Hari Kegiatan')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                    ])
                    ->placeholder('Pilih hari kegiatan')
                    ->searchable()
                    ->reactive(),

                TextArea::make('isi_ektra')
                    ->label('Deskripsi')
                    ->maxLength(500)
                    ->placeholder('Masukkan deskripsi ekstrakurikuler'),
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
                TextColumn::make('judul_ektra')
                    ->label('Nama Ekstrakurikuler')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                ImageColumn::make('gambar_ektra')
                    ->label('Foto Ekstrakurikuler')
                    ->sortable()
                    ->searchable()
                    ->square()
                    ->size(50),
                TextColumn::make('isi_ektra')
                    ->label('Deskripsi')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                TextColumn::make('pembina')
                    ->label('Nama Pembina')
                    ->sortable()
                    ->searchable()
                    ->limit(50),
                TextColumn::make('hari') 
                    ->label('Hari Kegiatan')
                    ->sortable()
                    ->searchable()
                    ->limit(20),
            ])
            ->filters([
                SelectFilter::make('hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                    ])
                    ->label('Hari Kegiatan'),
            ])->actions([

                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])->label('Aksi'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresconfirmation()
                    ->modalHeading('Hapus Ekstrakurikuler')
                    ->modalSubheading('Anda yakin ingin menghapus ekstrakurikuler ini? Ini tidak bisa dibatalkan.')
                    ->action(fn(Ektra $record) => $record->delete())
                    ->successNotificationTitle('Ekstrakurikuler berhasil dihapus!'),
                ViewAction::make()
                    ->modalHeading('Detail Ekstrakurikuler'),
            ])
            ->bulkActions([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Ekstrakurikuler')
                        ->modalSubheading('Anda yakin ingin menghapus ekstrakurikuler yang dipilih? Ini tidak bisa dibatalkan.')
                        ->action(fn(Collection $records) => $records->each(fn(Ektra $record) => $record->delete()))
                        ->successNotificationTitle('Ekstrakurikuler berhasil dihapus!')->label('Hapus ekstrakurikuler yang dipilih'),

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
