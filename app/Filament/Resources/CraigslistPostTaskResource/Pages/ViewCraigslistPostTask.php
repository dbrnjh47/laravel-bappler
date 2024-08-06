<?php

namespace App\Filament\Resources\CraigslistPostTaskResource\Pages;

use App\Filament\Resources\CraigslistPostTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCraigslistPostTask extends ViewRecord
{
    protected static string $resource = CraigslistPostTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
