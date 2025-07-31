<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

    protected static ?string $title = 'Edit Banner';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Konten Website';

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
                'judul_banner' => ['required', 'string', 'max:50'],
                'gambar_banner' => ['required', 'max:2048'], // max 2MB
                'deskripsi_banner' => ['nullable', 'string', 'max:2048'],
                'link_banner' => ['nullable', 'url'],
            ], [
                'judul_banner.required' => 'Judul banner harus diisi.',
                'judul_banner.max' => 'Judul banner maksimal 50 karakter.',
                'deskripsi_banner.max' => 'Deskripsi banner maksimal 1000 karakter.',
                'gambar_banner.required' => 'Gambar banner harus diunggah.',
                'gambar_banner.max' => 'Ukuran gambar maksimal 2MB.',
                'link_banner.url' => 'Link harus berupa URL yang valid.',
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
            ->title('Banner berhasil diperbarui!')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
