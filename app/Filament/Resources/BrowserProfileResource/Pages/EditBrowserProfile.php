<?php

namespace App\Filament\Resources\BrowserProfileResource\Pages;

use App\Filament\Resources\BrowserProfileResource;
use App\Http\Controllers\Craigslist\CraigslistController;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBrowserProfile extends EditRecord
{
    protected static string $resource = BrowserProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('Update posts')
            ->color("gray")
            ->requiresConfirmation()
            ->action(function ($record, $livewire)
                {
                    (new CraigslistController)->parse($record);
                    Notification::make()
                    ->title('Update is queued')
                    ->success()
                    ->send();
                }
            )->hidden(! auth()->user()->can('IT | Craigslist Post | Parse')),
        ];
    }
}
