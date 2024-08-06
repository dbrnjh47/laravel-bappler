<?php

namespace App\Filament\Resources\CraigslistPostTemplateResource\Pages;

use App\Filament\Resources\CraigslistPostTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCraigslistPostTemplate extends EditRecord
{
    protected static string $resource = CraigslistPostTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
