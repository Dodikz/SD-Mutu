<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Tambah User';

    public function getBreadcrumb(): string
    {
        return 'Tambah User';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Validator::make($data, [
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'min:8', 'confirmed'],
                'jabatan' => ['required', 'max:255'],
                'alamat' => ['required', 'max:255'],
                'no_hp' => ['required', 'max:255'],
            ], [
                'name.required' => 'Nama harus diisi!',
                'name.max' => 'Nama maksimal 100 karakter.',
                'email.required' => 'Email harus diisi!',
                'email.email' => 'Email tidak valid!',
                'email.max' => 'Email maksimal 100 karakter.',
                'email.unique' => 'Email sudah digunakan!',
                'password.required' => 'Password harus diisi!',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Password tidak sesuai!',
                'jabatan.required' => 'Jabatan harus diisi!',
                'jabatan.max' => 'Jabatan maksimal 100 karakter.',
                'alamat.required' => 'Alamat harus diisi!',
                'alamat.max' => 'Alamat maksimal 100 karakter.',
                'no_hp.required' => 'Nomor HP harus diisi!',
                'no_hp.max' => 'Nomor HP maksimal 100 karakter.',
            ])->validate();

            return $this->getModel()::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'jabatan' => $data['jabatan'],
                'alamat' => $data['alamat'],
                'no_hp' => $data['no_hp'],
            ]);
        } catch (ValidationException $e) {                                  
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan user')
                        ->body($message)
                        ->danger()
                        ->duration(5000)
                        ->send();
                }
            }
            throw $e;
        }
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('User berhasil ditambahkan!')
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
            $this->getCreateFormAction()->label('Simpan'),
        ];
    }

}
