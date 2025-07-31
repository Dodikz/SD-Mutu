<?php

namespace App\Filament\Resources\GambarSaranaResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use App\Filament\Resources\GambarSaranaResource;

class CreateGambarSarana extends CreateRecord
{
    protected static string $resource = GambarSaranaResource::class;
    protected static ?string $title = 'Tambah Gambar Sarana';

    public function getBreadcrumb(): string
    {
        return 'Tambah Gambar Sarana';
    }

     protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Validator::make($data, [
                'sarana_id' => ['required', 'exists:saranas,id'],
                'gambar' => ['required', 'max:2048'],
            ], [
                'sarana_id.required' => 'Sarana wajib dipilih.',
                'sarana_id.exists' => 'Sarana tidak valid.',
                'gambar.required' => 'Gambar harus diunggah.',
                'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            ])->validate();
            return $this->getModel()::create($data);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan gambar sarana')
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
            ->title('Gambar Sarana berhasil ditambahkan')
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
