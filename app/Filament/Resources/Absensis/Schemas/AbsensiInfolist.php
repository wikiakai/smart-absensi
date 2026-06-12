<?php

namespace App\Filament\Resources\Absensis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AbsensiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('pegawai_id')
                    ->numeric(),
                TextEntry::make('tanggal')
                    ->date(),
                TextEntry::make('jam_masuk')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('jam_siang')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('jam_pulang')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('keterangan'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
