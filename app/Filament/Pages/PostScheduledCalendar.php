<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PostScheduledCalendarWidget;
use App\Models\PostScheduled;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Resources\Components\Tab;

class PostScheduledCalendar extends Page
{
    protected static ?string $model = PostScheduled::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.pages.post_scheduled-calendar';

    protected static ?string $navigationLabel = 'Post Schedule';
    protected static ?string $title = 'Post Schedule';
    // public function getTitle(): string
    // {
    //     return 'Post Schedule';
    // }

    protected static ?int $navigationSort = 51;

    protected static ?string $navigationGroup = 'Marketing';

    protected function getHeaderWidgets(): array
    {
        return [
            // PostScheduledCalendarWidget::class
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'all2' => Tab::make(),
        ];
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->action(function (array $arguments) {
            });
    }

    public function cAction(): Action
    {
        return Action::make('c')
            ->action(function (array $arguments) {
            });
    }
}
