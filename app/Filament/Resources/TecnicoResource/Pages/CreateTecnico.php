<?php

namespace App\Filament\Resources\TecnicoResource\Pages;

use App\Filament\Resources\TecnicoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTecnico extends CreateRecord
{
    protected static string $resource = TecnicoResource::class;
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.tecnicos.index');
    }
}
