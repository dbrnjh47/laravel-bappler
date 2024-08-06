<?php

namespace App\Filament\Resources\CraigslistPostResource\Pages;

use App\Filament\Resources\CraigslistPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCraigslistPosts extends ListRecords
{
    protected static string $resource = CraigslistPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
