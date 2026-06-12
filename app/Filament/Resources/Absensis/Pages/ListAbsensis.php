<?php

namespace App\Filament\Resources\Absensis\Pages;

use App\Filament\Resources\Absensis\AbsensiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use App\Models\Absensi;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('input_all')
                ->label('Input Absensi')
                ->schema([
                    DatePicker::make('tanggal')
                        ->label('Pilih Tanggal Absensi')
                        ->required()
                        ->default(now()->toDateString())
                        ->native(false),
                ])
                ->action(function (array $data, Action $action) {
                    $tanggal = $data['tanggal'];

                    // Cek apakah tanggal sudah ada di tabel absensis
                    $dateExists = Absensi::where('tanggal', '=', $tanggal)->exists();

                    if ($dateExists) {
                        // Munculkan notifikasi gagal di pojok kanan atas
                        Notification::make()
                            ->title('Tanggal Sudah Ada!')
                            ->body("Data absensi untuk tanggal " . date('d-m-Y', strtotime($tanggal)) . " sudah pernah diinput sebelumnya.")
                            ->danger()
                            ->send();

                        // Hentikan proses action agar tidak jadi redirect
                        $action->halt();
                        return;
                    }

                    // Jika belum ada, lanjut redirect
                    return redirect()->to(
                        AbsensiResource::getUrl('input-absensi', ['tanggal' => $tanggal])
                    );
                }),
            // ->url(InputAbsensi::getUrl())
        ];
    }
}
