<?php

namespace App\Filament\Resources\BrowserGroupResource\Pages;

use App\Filament\Resources\BrowserGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Http\Services\Browser\BrowserGroupServices;

class ListBrowserGroups extends ListRecords
{
    protected static string $resource = BrowserGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Update')
                ->color("gray")
                ->requiresConfirmation()
                ->action(function ()
                    {
                        (new BrowserGroupServices)->update();
                        \Filament\Notifications\Notification::make()
                        ->title('Successfully')
                        ->success()
                        ->send();
                    }
                ),
        ];
    }
}
