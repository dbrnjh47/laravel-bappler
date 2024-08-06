<?php

namespace App\Filament\Resources\BrowserGroupResource\Pages;

use App\Filament\Resources\BrowserGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrowserGroup extends EditRecord
{
    protected static string $resource = BrowserGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
