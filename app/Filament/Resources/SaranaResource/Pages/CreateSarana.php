<?php

namespace App\Filament\Resources\SaranaResource\Pages;

use App\Filament\Resources\SaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateSarana extends CreateRecord
{
    protected static string $resource = SaranaResource::class;
    protected static ?string $title = 'Tambah Sarana & Prasarana';

    public function getBreadcrumb(): string
    {
        return 'Tambah Sarana';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Validator::make($data, [
                'namasarana' => ['required', 'max:255'],
                'keterangan' => ['required'],
            ], [
                'namasarana.required' => 'Nama sarana harus diisi!',
                'namasarana.max' => 'Nama sarana maksimal 255 karakter.',
                'keterangan.required' => 'Keterangan harus diisi!',
            ])->validate();

            return $this->getModel()::create([
                'namasarana' => $data['namasarana'],
                'keterangan' => $data['keterangan'],
            ]);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan sarana')
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
            ->title('Sarana berhasil ditambahkan!')
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
