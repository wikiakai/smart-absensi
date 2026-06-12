<?php

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PegawaiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nip')
                    ->placeholder('-'),
                TextEntry::make('nama'),
                TextEntry::make('jabatan')
                    ->placeholder('-'),
                TextEntry::make('bidang')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
