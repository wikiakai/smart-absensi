<?php

namespace App\Filament\Resources\Absensis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class AbsensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('tanggal')
                    ->required(),
                TimePicker::make('jam_masuk'),
                TimePicker::make('jam_siang'),
                TimePicker::make('jam_pulang'),
                TextInput::make('keterangan')
                    ->required()
                    ->default('Hadir'),
            ]);
    }
}
