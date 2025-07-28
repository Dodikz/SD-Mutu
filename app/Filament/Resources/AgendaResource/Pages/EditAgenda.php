<?php

namespace App\Filament\Resources\AgendaResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use App\Filament\Resources\AgendaResource;
use Illuminate\Validation\ValidationException;

class EditAgenda extends EditRecord
{
    protected static string $resource = AgendaResource::class;

    protected function getSavedNotification(): ?Notification
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

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Agenda berhasil ditambahkan!')
            ->success()
            ->send();
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
                'jam_selesai_agenda.required' => 'Jam selesai agenda harus diisi.',
                'tanggal_agenda.required' => 'Tanggal agenda harus diisi.',
            ])->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Notification::make()
                        ->title('Gagal memperbarui data')
                        ->body($message)
                        ->danger()
                        ->send();
                }
            }
            throw $e;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
