<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\BeritaResource;
use Illuminate\Validation\ValidationException;

class EditBerita extends EditRecord
{
    protected static string $resource = BeritaResource::class;
    protected static ?string $title = 'Edit Berita';
    public function getBreadcrumb(): string
    {
        return 'Edit Berita';
    }

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            Validator::make($data, [
                'judul_berita' => ['required', 'max:255'],
                'isi_berita' => ['required'],
                'gambar_berita' => ['nullable', 'max:2048'], 
                'user_id' => ['required', 'exists:users,id'],
            ], [
                'judul_berita.required' => 'Judul Berita harus diisi!',
                'judul_berita.max' => 'Judul Berita maksimal 255 karakter.',
                'isi_berita.required' => 'Isi Berita harus diisi!',
                'gambar_berita.max' => 'Gambar Berita maksimal 2MB.',
                'user_id.required' => 'User harus diisi!',
                'user_id.exists' => 'User tidak ditemukan!',
            ])->validate();

            
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui berita')
                        ->body($message)
                        ->danger()
                        ->duration(5000)
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
            ->title('Berita berhasil diperbarui!')
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
