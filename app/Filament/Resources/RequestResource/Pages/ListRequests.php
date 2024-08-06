<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListRequests extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = RequestResource::class;

    protected static ?string $title = "Visits";

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RequestResource\Widgets\RequestsChart::class,
        ];
    }
}
