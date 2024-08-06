<?php

namespace App\Filament\Resources\BrowserGroupResource\Pages;

use App\Filament\Resources\BrowserGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBrowserGroup extends ViewRecord
{
    protected static string $resource = BrowserGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
