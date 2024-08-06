<?php

namespace App\Filament\Resources\CraigslistPostTaskResource\Pages;

use App\Filament\Pages\PostScheduledCalendar;
use App\Filament\Resources\CraigslistPostTaskResource;
use Filament\Actions;
use Filament\Infolists\Components\View;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListCraigslistPostTasks extends ListRecords
{
    protected static string $resource = CraigslistPostTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected static string $view = 'filament.resources.craigslist_post_task.pages.list';
}
