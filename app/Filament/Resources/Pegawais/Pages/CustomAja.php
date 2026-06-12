<?php

namespace App\Filament\Resources\Pegawais\Pages;

use App\Filament\Resources\Pegawais\PegawaiResource;
use Filament\Resources\Pages\Page;

class CustomAja extends Page
{
    protected static string $resource = PegawaiResource::class;

    protected string $view = 'filament.resources.pegawais.pages.custom-aja';
}
