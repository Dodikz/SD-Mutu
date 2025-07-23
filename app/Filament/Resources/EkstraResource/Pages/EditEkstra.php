<?php

namespace App\Filament\Resources\EkstraResource\Pages;

use App\Filament\Resources\EkstraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditEkstra extends EditRecord
{
    protected static string $resource = EkstraResource::class;

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
                'judul_ektra'   => ['required', 'max:255'],
                'gambar_ektra'  => ['nullable', 'image', 'max:1024'],
                'isi_ektra'     => ['nullable', 'string', 'max:1000'],
                'pembina'       => ['required', 'string', 'max:255'],
                'hari'          => ['required', 'string', 'max:50'],
            ], [
                'judul_ektra.required' => 'Nama Ekstra harus diisi!',
                'judul_ektra.max'      => 'Nama Ekstra maksimal 255 karakter.',
                'gambar_ektra.image'   => 'File harus berupa gambar.',
                'gambar_ektra.max'     => 'Ukuran gambar maksimal 1MB.',
                'isi_ektra.max'        => 'Isi maksimal 1000 karakter.',
                'pembina.required'     => 'Nama pembina harus diisi.',
                'pembina.max'          => 'Nama pembina maksimal 255 karakter.',
                'hari.required'        => 'Hari kegiatan harus diisi.',
                'hari.max'             => 'Hari maksimal 50 karakter.',
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
            ->title('Ekstrakurikuler berhasil diperbarui!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
