<?php

namespace App\Filament\Resources\Absensis\Pages;

use App\Filament\Resources\Absensis\AbsensiResource;
use Filament\Resources\Pages\Page;

class InputAbsensi extends Page
{
    // use InteractsWithRecord;

    protected static string $resource = AbsensiResource::class;

    protected string $view = 'filament.resources.absensis.pages.input-absensi';

    public function mount(): void
    {
        // $this->record = $this->resolveRecord($record);
    }
}
