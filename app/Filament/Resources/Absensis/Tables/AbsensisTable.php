<?php

namespace App\Filament\Resources\Absensis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class AbsensisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // 1. MODIFIKASI QUERY: Hanya grup berdasarkan tanggal saja
            ->modifyQueryUsing(function (Builder $query) {
                $query->select('tanggal')
                    ->selectRaw("tanggal as id") // Menjadikan string tanggal sebagai ID bayangan agar rute View aman
                    ->selectRaw("COUNT(jam_masuk) as total_pagi")
                    ->selectRaw("COUNT(jam_siang) as total_siang")
                    ->selectRaw("COUNT(jam_pulang) as total_sore")
                    ->groupBy('tanggal')
                    ->orderBy('tanggal', 'desc');
            })
            // 2. TAMPILKAN KOLOM
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal Kerja')
                    ->date('d M Y') // Format tampilan: 12 Jun 2026
                    ->searchable()
                    ->sortable(),

                TextColumn::make('hari')
                    ->label('Hari')
                    ->getStateUsing(function ($record) {
                        $hari = date('N', strtotime($record->tanggal));
                        return match ($hari) {
                            '1' => 'Senin',
                            '2' => 'Selasa',
                            '3' => 'Rabu',
                            '4' => 'Kamis',
                            '5' => 'Jumat',
                            default => 'Akhir Pekan',
                        };
                    }),
                // Kolom Rekap Absen Pagi
                TextColumn::make('total_pagi')
                    ->label('Absen Pagi')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-sun')
                    ->alignCenter(),

                // Kolom Rekap Absen Siang
                TextColumn::make('total_siang')
                    ->label('Absen Siang')
                    ->badge()
                    ->color('warning')
                    ->icon('heroicon-m-cloud')
                    ->alignCenter(),

                // Kolom Rekap Absen Sore
                TextColumn::make('total_sore')
                    ->label('Absen Sore')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-moon')
                    ->alignCenter(),
            ])
            ->recordActions([
                // Sekarang tombol ViewAction bawaan Filament ini tidak akan error lagi
                ViewAction::make(),

            ]);
    }
}
