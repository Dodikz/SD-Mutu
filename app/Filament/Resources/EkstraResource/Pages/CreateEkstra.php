<?php

namespace App\Filament\Resources\EkstraResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\EkstraResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Mix;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateEkstra extends CreateRecord
{
    protected static string $resource = EkstraResource::class;
    protected static ?string $title = 'Tambah Ekstrakurikuler';
    
    public function getBreadcrumb(): string
    {
        return 'Tambah Ekstrakurikuler';
    }


    
     protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
    {
         try {
        Validator::make($data, [
            'judul_ektra' => ['required', 'max:255'],
            'gambar_ektra' => ['required'],
            'isi_ektra' => ['nullable', 'string', 'max:1000'],
            'pembina' => ['required', 'string', 'max:255'],
            'hari' => ['required', 'string', 'max:50'],
        ], [
            'judul_ektra.required' => 'Nama Ekstra harus diisi!',
            'judul_ektra.max' => 'Nama Ekstra maksimal 100 karakter.',
            'gambar_ektra.required' => 'Gambar Ekstra harus diunggah.',
            'isi_ektra.max' => 'Isi maksimal 1000 karakter.',
            'pembina.required' => 'Nama pembina harus diisi.',
            'pembina.max' => 'Nama pembina maksimal 100 karakter.',
            'hari.required' => 'Hari kegiatan harus diisi.',
            'hari.max' => 'Hari maksimal 50 karakter.',
        ])->validate();

        return $this->getModel()::create($data);
    } catch (ValidationException $e) {
        foreach ($e->errors() as $messages) {
            foreach ($messages as $message) {
                Notification::make()
                    ->title('Gagal menambahkan ekstrakurikuler')
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
            ->title('Ekstra berhasil ditambahkan!')
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
