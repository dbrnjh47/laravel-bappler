<?php

namespace App\Filament\Resources\CraigslistPostTemplateResource\Pages;

use App\Filament\Resources\CraigslistPostTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCraigslistPostTemplates extends ListRecords
{
    protected static string $resource = CraigslistPostTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
