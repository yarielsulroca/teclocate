<?php

namespace App\Filament\Resources\VisitaResource\Pages;

use App\Filament\Resources\VisitaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVisita extends CreateRecord
{
    protected static string $resource = VisitaResource::class;
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.visitas.index');
    }
}
