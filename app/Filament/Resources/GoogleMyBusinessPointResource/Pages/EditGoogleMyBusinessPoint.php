<?php

namespace App\Filament\Resources\GoogleMyBusinessPointResource\Pages;

use App\Filament\Resources\GoogleMyBusinessPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGoogleMyBusinessPoint extends EditRecord
{
    protected static string $resource = GoogleMyBusinessPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
