<?php

namespace App\Filament\Resources\KaryaGuruResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\KaryaGuruResource;
use Illuminate\Validation\ValidationException;

class CreateKaryaGuru extends CreateRecord
{
    protected static string $resource = KaryaGuruResource::class;
    protected static ?string $title = 'Tambah Karya Guru';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?string $navigationLabel = 'Karya Guru';

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

            return $this->getModel()::create($data);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan Karya Guru')
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
            ->title('Karya Guru berhasil ditambahkan!')
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
