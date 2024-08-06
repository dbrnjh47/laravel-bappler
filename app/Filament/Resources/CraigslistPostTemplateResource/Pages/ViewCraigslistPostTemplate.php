<?php

namespace App\Filament\Resources\CraigslistPostTemplateResource\Pages;

use App\Filament\Resources\CraigslistPostTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCraigslistPostTemplate extends ViewRecord
{
    protected static string $resource = CraigslistPostTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
