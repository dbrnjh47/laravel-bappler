<?php

namespace App\Filament\Resources\CraigslistPostResource\Pages;

use App\Filament\Resources\CraigslistPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCraigslistPost extends EditRecord
{
    protected static string $resource = CraigslistPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
