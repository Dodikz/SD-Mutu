<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';


    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen User';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('name')
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn($state) => filled($state))
                        ->label('Password')
                        ->revealable(),
                    TextInput::make('jabatan')
                        ->maxLength(50),
                    TextInput::make('alamat')
                        ->maxLength(255),
                    TextInput::make('no_hp')
                        ->label('Nomor Handphone')
                        ->prefix('+62')
                        ->minLength(9)
                        ->maxLength(13)
                        ->tel()
                        ->rule('regex:/^[0-9]{9,13}$/')
                        ->dehydrateStateUsing(fn($state) => '+62' . ltrim($state, '0'))
                        ->afterStateHydrated(
                            fn($component, $state) =>
                            $component->state(str_replace('+62', '', $state))
                        )
                ])->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                    '2xl' => 2,
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('password')->hidden(fn(): bool => true),
                TextColumn::make('jabatan')->sortable()->searchable(),
                TextColumn::make('alamat')->sortable()->searchable(),
                TextColumn::make('no_hp')->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'guru' => 'Guru',
                    ])
                    ->label('Role')
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle('Pengguna berhasil dihapus.')
                    ->modalHeading('Hapus Pengguna')
                    ->modalSubheading('Anda yakin ingin menghapus pengguna yang dipilih? Ini tidak bisa dibatalkan.')
                    ->modalButton('Hapus')
                    ->modalCancelActionLabel('Batalkan')
                    ->action(fn($records) => $records->each(fn(User $record) => $record->delete()))
                    ->deselectRecordsAfterCompletion()
                    ->label('Hapus pengguna yang dipilih'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
