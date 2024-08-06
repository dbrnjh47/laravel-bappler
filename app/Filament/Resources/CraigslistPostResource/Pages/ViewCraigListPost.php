<?php

namespace App\Filament\Resources\CraigslistPostResource\Pages;

use App\Filament\Resources\CraigslistPostResource;
use App\Http\Controllers\Craigslist\CraigslistController;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewCraigslistPost extends ViewRecord
{
    protected static string $resource = CraigslistPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('Post')
                        ->color("gray")
                        ->requiresConfirmation()
                        ->icon("heroicon-o-arrow-path")
                        ->action(
                            function ($record, $livewire) {
                                (new CraigslistController)->post($record->id);
                                Notification::make()
                                    ->title('Post is queued')
                                    ->success()
                                    ->send();
                            }
                        )->hidden(! auth()->user()->can('IT | Craigslist Post | Post')),
        ];
    }
}
