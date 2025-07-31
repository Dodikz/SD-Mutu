<?php

namespace App\Filament\Resources\PengumumanResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PengumumanResource;
use Illuminate\Validation\ValidationException;

class CreatePengumuman extends CreateRecord
{
    protected static string $resource = PengumumanResource::class;
    protected static ?string $title = 'Tambah Pengumuman';
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?string $navigationLabel = 'Pengumuman';

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
                'nama_pengumumen' => ['required', 'string', 'max:50'],
                'file_pengumumen' => ['required', 'max:5120'],
            ], [
                'nama_pengumumen.required' => 'Nama pengumuman harus diisi.',
                'nama_pengumumen.max' => 'Nama pengumuman maksimal 50 karakter.',
                'file_pengumumen.required' => 'File pengumuman harus diunggah.',
                'file_pengumumen.max' => 'Ukuran file maksimal 5MB.',
            ])->validate();

            return $this->getModel()::create($data);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan Pengumuman')
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
            ->title('Pengumuman berhasil ditambahkan!')
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
