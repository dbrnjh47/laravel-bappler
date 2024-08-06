<?php

namespace App\Filament\Resources\GoogleMyBusinessPointResource\Pages;

use App\Filament\Resources\GoogleMyBusinessPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGoogleMyBusinessPoints extends ListRecords
{
    protected static string $resource = GoogleMyBusinessPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
