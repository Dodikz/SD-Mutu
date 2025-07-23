<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use App\Filament\Resources\ProfilResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EditProfil extends EditRecord
{
    protected static string $resource = ProfilResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
    protected static ?string $title = 'Edit Profil';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected function getSavedNotification(): ?Notification
    {
        return null;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        try {
            Validator::make($data, [
                'kepala_sekolah' => ['required', 'max:255'],
                'foto_kepala_sekolah' => ['required', 'max:255'],
                'sambutan_kepala_sekolah' => ['required'],
                'sejarah' => ['required'],
                'visi' => ['required'],
                'misi' => ['required'],
                'akreditasi' => ['required'],
            ], [
                'kepala_sekolah.required' => 'Kepala Sekolah harus diisi!',
                'kepala_sekolah.max' => 'Kepala Sekolah maksimal 255 karakter.',
                'foto_kepala_sekolah.required' => 'Foto Kepala Sekolah harus diisi!',
                'foto_kepala_sekolah.max' => 'Foto Kepala Sekolah maksimal 255 karakter.',
                'sambutan_kepala_sekolah.required' => 'Sambutan Kepala Sekolah harus diisi!',
                'sejarah.required' => 'Sejarah harus diisi!',
                'visi.required' => 'Visi harus diisi!',
                'misi.required' => 'Misi harus diisi!',
                'akreditasi.required' => 'Akreditasi harus diisi!',
            ])->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui profile')
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
            ->title('Profil berhasil diupdate!')
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
