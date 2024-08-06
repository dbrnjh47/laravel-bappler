<?php

namespace App\Filament\Resources\ProxyResource\Pages;

use App\Filament\Resources\ProxyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProxy extends ViewRecord
{
    protected static string $resource = ProxyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
