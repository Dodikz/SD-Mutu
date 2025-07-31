<?php

namespace App\Filament\Resources\PrestasiResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\PrestasiResource;
use Illuminate\Validation\ValidationException;

class EditPrestasi extends EditRecord
{
    protected static string $resource = PrestasiResource::class;
    protected static ?string $title = 'Ubah Prestasi';
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Kegiatan & Prestasi';
    protected static ?string $navigationLabel = 'Prestasi';
    public function getBreadcrumb(): string
    {
        return 'Ubah Prestasi';
    }

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
                'jenis_prestasi' => ['required', 'in:Akademik,Non Akademik'],
                'nama_prestasi' => ['required', 'max:50'],
                'keterangan_prestasi' => ['required', 'max:100'],
                'penyelenggara' => ['required', 'max:50'],
                'peringkat' => ['required', 'max:50'],
                'bidang' => ['required', 'max:50'],
                'gambar_prestasi' => ['required', 'max:2048'],
            ], [
                'jenis_prestasi.required' => 'Jenis prestasi harus diisi!',
                'jenis_prestasi.in' => 'Jenis prestasi harus berupa Akademik atau Non Akademik.',
                'nama_prestasi.required' => 'Nama prestasi harus diisi!',
                'nama_prestasi.max' => 'Nama prestasi maksimal 50 karakter.',
                'keterangan_prestasi.required' => 'Keterangan prestasi harus diisi!',
                'keterangan_prestasi.max' => 'Keterangan prestasi maksimal 100 karakter.',
                'penyelenggara.required' => 'Penyelenggara harus diisi!',
                'penyelenggara.max' => 'Penyelenggara maksimal 50 karakter.',
                'peringkat.required' => 'Peringkat harus diisi!',
                'peringkat.max' => 'Peringkat maksimal 50 karakter.',
                'bidang.required' => 'Bidang harus diisi!',
                'bidang.max' => 'Bidang maksimal 50 karakter.',
                'gambar_prestasi.required' => 'Gambar prestasi harus diisi!',
                'gambar_prestasi.max' => 'Gambar prestasi maksimal 2048 KB.',
            ])->validate();
            return $data;
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui prestasi sarana')
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
            ->title('Prestasi Sarana berhasil diperbarui')
            ->success()
            ->send();
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}
