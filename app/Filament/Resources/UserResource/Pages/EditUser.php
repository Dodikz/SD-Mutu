<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Edit User';

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    public function getBreadcrumb(): string
    {
        return 'Edit User';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Validator::make($data, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'jabatan' => ['required', 'max:255'],
            'alamat' => ['required', 'max:255'],
            'no_hp' => ['required', 'max:255'],
        ], [
            'name.required' => 'Nama harus diisi!',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Email tidak valid!',
            'email.max' => 'Email maksimal 100 karakter.',
            'jabatan.required' => 'Jabatan harus diisi!',
            'jabatan.max' => 'Jabatan maksimal 100 karakter.',
            'alamat.required' => 'Alamat harus diisi!',
            'alamat.max' => 'Alamat maksimal 100 karakter.',
            'no_hp.required' => 'Nomor HP harus diisi!',
            'no_hp.max' => 'Nomor HP maksimal 100 karakter.',
        ])->validate();

        return $data;
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('User berhasil diperbarui!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction()->label('Batal'),
            $this->getSaveFormAction()->label('Perbarui'),
        ];
    }
}
