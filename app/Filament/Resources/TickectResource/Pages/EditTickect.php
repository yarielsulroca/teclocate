<?php

namespace App\Filament\Resources\TickectResource\Pages;

use App\Filament\Resources\TickectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTickect extends EditRecord
{
    protected static string $resource = TickectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
