<?php

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PegawaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nip'),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('jabatan'),
                TextInput::make('bidang'),
            ]);
    }
}
