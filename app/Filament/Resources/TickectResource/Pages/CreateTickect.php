<?php

namespace App\Filament\Resources\TickectResource\Pages;

use App\Filament\Resources\TickectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTickect extends CreateRecord
{
    protected static string $resource = TickectResource::class;
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.tickects.index');
    }
}
