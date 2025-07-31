<?php

namespace App\Filament\Resources\GambarSaranaResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Filament\Resources\GambarSaranaResource;

class EditGambarSarana extends EditRecord
{
    protected static string $resource = GambarSaranaResource::class;

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
                'sarana_id' => ['required', 'exists:saranas,id'],
                'gambar' => ['required', 'max:2048'],
            ], [
                'sarana_id.required' => 'Sarana wajib dipilih.',
                'sarana_id.exists' => 'Sarana tidak valid.',
                'gambar.required' => 'Gambar harus diunggah.',
                'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            ])->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui gambar sarana')
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
            ->title('Gambar Sarana berhasil diperbarui')
            ->success()
            ->send();
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
