<?php

namespace App\Filament\Resources\KaryaGuruResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\KaryaGuruResource;
use Illuminate\Validation\ValidationException;

class EditKaryaGuru extends EditRecord
{
    protected static string $resource = KaryaGuruResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction()->label('Batal'),
            $this->getSaveFormAction()->label('Simpan'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
           Validator::make($data, [
                'nama_karya_guru' => ['required', 'string', 'max:50'],
                'slug' => ['required', 'string', 'max:50'],
                'foto_karya_guru' => ['required', 'max:5120'],
                'isi_karya' => ['required', 'string'],
                'user_id' => ['required', 'integer'],
            ], [
                'nama_karya_guru.unique' => 'Nama Karya Guru sudah ada.',
                'slug.unique' => 'Slug Karya Guru sudah ada.',
                'foto_karya_guru.required' => 'Foto Karya Guru harus diunggah.',
                'foto_karya_guru.max' => 'Ukuran foto Karya Guru tidak boleh lebih dari 5MB.',
                'isi_karya.required' => 'Isi Karya Guru tidak boleh kosong.',
                'user_id.required' => 'Nama guru harus diisi.',
            ])->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui data')
                        ->body($message)
                        ->danger()
                        ->send();
                }
            }
            throw $e;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Karya Guru berhasil diperbarui!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
