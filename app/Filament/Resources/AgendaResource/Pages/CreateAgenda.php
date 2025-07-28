<?php

namespace App\Filament\Resources\AgendaResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use App\Filament\Resources\AgendaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Validator;

class CreateAgenda extends CreateRecord
{
    protected static string $resource = AgendaResource::class;
    protected static ?string $title = 'Tambah Agenda';
    public function getBreadcrumb(): string
    {
        return 'Tambah Agenda';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Simpan')
                ->color('primary'),
            Actions\Action::make('cancel')
                ->label('Batal')
                ->color('secondary'),
        ];
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Agenda berhasil ditambahkan!')
            ->success()
            ->send();
    }

    protected function handleRecordCreation(array $data): Model
    {
        try {
            Validator::make($data, [
                'judul_agenda' => ['required', 'max:100'],
                'lokasi_agenda' => ['required', 'max:100'],
                'jam_mulai_agenda' => ['required', 'date_format:H:i'],
                'jam_selesai_agenda' => ['required', 'date_format:H:i'],
                'tanggal_agenda' => ['required', 'date'],
            ], [
                'judul_agenda.required' => 'Judul agenda harus diisi!',
                'judul_agenda.max' => 'Judul agenda maksimal 100 karakter.',
                'lokasi_agenda.required' => 'Lokasi agenda harus diisi.',
                'lokasi_agenda.max' => 'Lokasi agenda maksimal 100 karakter.',
                'jam_mulai_agenda.required' => 'Jam mulai agenda harus diisi.',
                'jam_mulai_agenda.date_format' => 'Format jam mulai tidak valid.',
                'jam_selesai_agenda.required' => 'Jam selesai agenda harus diisi.',
                'jam_selesai_agenda.date_format' => 'Format jam selesai tidak valid.',
                'tanggal_agenda.required' => 'Tanggal agenda harus diisi.',
                'tanggal_agenda.date' => 'Tanggal agenda tidak valid.',
            ])->validate();

            return $this->getModel()::create($data);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menambahkan agenda')
                ->body($e->getMessage())
                ->danger()
                ->duration(5000)
                ->send();
            throw $e;
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
