<?php

namespace App\Filament\Resources\PengumumanResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\PengumumanResource;
use Illuminate\Validation\ValidationException;

class EditPengumuman extends EditRecord
{
    protected static string $resource = PengumumanResource::class;

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
                'nama_pengumumen' => ['required', 'string', 'max:50'],
                'file_pengumumen' => ['required', 'max:5120'],
            ], [
                'nama_pengumumen.required' => 'Nama pengumuman harus diisi.',
                'nama_pengumumen.max' => 'Nama pengumuman maksimal 50 karakter.',
                'file_pengumumen.required' => 'File pengumuman harus diunggah.',
                'file_pengumumen.max' => 'Ukuran file maksimal 5MB.',
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
            ->title('Pengumuman berhasil diperbarui!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
