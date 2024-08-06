<?php

namespace App\Filament\Resources\CraigslistPostTaskResource\Pages;

use App\Filament\Resources\CraigslistPostTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCraigslistPostTask extends EditRecord
{
    protected static string $resource = CraigslistPostTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
