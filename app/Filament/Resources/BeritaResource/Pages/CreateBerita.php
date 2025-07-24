<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\BeritaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateBerita extends CreateRecord
{
    protected static string $resource = BeritaResource::class;
    protected static ?string $title = 'Tambah Berita';

    public function getBreadcrumb(): string
    {
        return 'Tambah Berita';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Validator::make($data, [
                'judul_berita' => ['required', 'max:255'],
                'isi_berita' => ['required'],
                'slug' => [],
                'gambar_berita' => ['nullable', 'max:2048'],
                'user_id' => ['required', 'exists:users,id'],

            ], [
                'judul_berita.required' => 'Judul Berita harus diisi!',
                'judul_berita.max' => 'Judul Berita maksimal 255 karakter.',
                'isi_berita.required' => 'Isi Berita harus diisi!',
                'gambar_berita.image' => 'File yang diunggah harus berupa gambar.',
                'user_id.required' => 'User harus diisi!',
                'user_id.exists' => 'User tidak ditemukan!',
            ])->validate();

            return $this->getModel()::create([
                'judul_berita' => $data['judul_berita'],
                'isi_berita' => $data['isi_berita'],
                'slug' => $data['slug'],
                'gambar_berita' => $data['gambar_berita'],
                'user_id' => $data['user_id'],
            ]);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan berita')
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
            ->title('Berita berhasil ditambahkan!')
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
