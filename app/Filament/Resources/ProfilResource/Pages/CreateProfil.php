<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\ProfilResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateProfil extends CreateRecord
{
    protected static string $resource = ProfilResource::class;
    protected static ?string $title = 'Tambah Profil Sekolah';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Profil Sekolah';

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction()->label('Batal'),
            $this->getCreateFormAction()->label('Simpan'),
        ];
    }

    public function handleRecordCreation(array $data): Model
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
                'kepala_sekolah.required' => 'Kepala sekolah harus diisi!',
                'kepala_sekolah.max' => 'Kepala sekolah maksimal 255 karakter.',
                'foto_kepala_sekolah.required' => 'Foto kepala sekolah harus diisi!',
                'foto_kepala_sekolah.max' => 'Foto kepala sekolah maksimal 255 karakter.',
                'sambutan_kepala_sekolah.required' => 'Sambutan kepala sekolah harus diisi!',
                'sejarah.required' => 'Sejarah harus diisi!',
                'visi.required' => 'Visi harus diisi!',
                'misi.required' => 'Misi harus diisi!',
                'akreditasi.required' => 'Akreditasi harus diisi!',
            ])->validate();
            return $this->getModel()::create($data);
       } catch (ValidationException $e) {
        foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal menambahkan Profil Sekolah')
                        ->body($message)
                        ->danger()
                        ->duration(5000)
                        ->send();
                }
            }
            throw $e;
       }
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.superadmin.resources.profils.index');
    }
}
