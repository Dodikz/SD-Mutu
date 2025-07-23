<?php
namespace App\Filament\Resources\TestimoniResource\Pages;

use App\Filament\Resources\TestimoniResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditTestimoni extends EditRecord
{
    protected static string $resource = TestimoniResource::class;

        protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            Validator::make($data, [
                'isi_testimoni' => ['required', 'max:255'],
                'penulis' => ['required', 'max:255'],
                'status' => ['required', 'boolean'],
            ], [
                'isi_testimoni.required' => 'Isi testimoni harus diisi!',
                'isi_testimoni.max' => 'Isi testimoni maksimal 255 karakter.',
                'penulis.required' => 'Penulis harus diisi!',
                'penulis.max' => 'Penulis maksimal 255 karakter.',
                'status.required' => 'Status harus diisi!',
                'status.boolean' => 'Status tidak valid!',
            ])->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui testimoni')
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
            ->title('Testimoni berhasil diupdate!')
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
            $this->getSaveFormAction()->label('Simpan'),
        ];
    }
}
