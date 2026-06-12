<?php

namespace App\Filament\Resources\Absensis\Pages;

use App\Filament\Resources\Absensis\AbsensiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('input_all')
                ->label('Input Absensi')
                ->schema([
                    TextInput::make('tanggal')
                        ->label('Tanggal')
                        ->type('date')
                        ->required(),
                ])
            // ->url(InputAbsensi::getUrl())
        ];
    }
}
