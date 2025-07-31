<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;
    protected static ?string $title = 'Tambah Banner';

    public function getBreadcrumb(): string
    {
        return 'Tambah Banner';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
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

            return $this->getModel()::create($data);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan banner')
                        ->body($message)
                        ->danger()
                        ->send();
                }
            }
            throw $e;
        }
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Banner berhasil ditambahkan!')
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
