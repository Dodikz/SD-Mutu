<?php

namespace App\Filament\Resources\TestimoniResource\Pages;

use App\Filament\Resources\TestimoniResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateTestimoni extends CreateRecord
{
    protected static string $resource = TestimoniResource::class;
    protected static ?string $title = 'Tambah Testimoni';

    public function getBreadcrumb(): string
    {
        return 'Tambah Testimoni';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Validator::make($data, [
                'isi_testimoni' => ['required', 'max:255'],
                'penulis' => ['required', 'max:255'],
                'status' => ['required', 'in:0,1'],
            ], [
                'isi_testimoni.required' => 'Isi testimoni harus diisi!',
                'isi_testimoni.max' => 'Isi testimoni maksimal 255 karakter.',
                'penulis.required' => 'Penulis harus diisi!',
                'penulis.max' => 'Penulis maksimal 255 karakter.',
                'status.required' => 'Status harus dipilih!',
                'status.in' => 'Status harus berupa (Tidak Aktif) atau (Aktif).',
            ])->validate();

            return $this->getModel()::create([
                'isi_testimoni' => $data['isi_testimoni'],
                'penulis' => $data['penulis'],
                'status' => $data['status'],
            ]);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan testimoni')
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
            ->title('Testimoni berhasil ditambahkan!')
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

