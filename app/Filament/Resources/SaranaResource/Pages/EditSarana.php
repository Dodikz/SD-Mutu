<?php

namespace App\Filament\Resources\SaranaResource\Pages;

use App\Filament\Resources\SaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditSarana extends EditRecord
{
    protected static string $resource = SaranaResource::class;
    protected static ?string $title = 'Edit Sarana & Prasarana';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected function getSavedNotification(): ?Notification
    {
        return null;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            Validator::make($data, [
                'namasarana' => ['required', 'max:255'],
                'keterangan' => ['required', 'max:255'],
            ], [
                'namasarana.required' => 'Nama sarana harus diisi!',
                'namasarana.max' => 'Nama sarana maksimal 255 karakter.',
                'keterangan.required' => 'Keterangan harus diisi!',
                'keterangan.max' => 'Keterangan maksimal 255 karakter.',
            ])->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui sarana')
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
            ->title('Sarana berhasil diupdate!')
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
