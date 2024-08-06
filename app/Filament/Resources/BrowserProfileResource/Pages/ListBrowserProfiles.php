<?php

namespace App\Filament\Resources\BrowserProfileResource\Pages;

use App\Filament\Resources\BrowserProfileResource;
use App\Http\Services\Browser\BrowserProfileServices;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrowserProfiles extends ListRecords
{
    protected static string $resource = BrowserProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Update')
                ->color("gray")
                ->requiresConfirmation()
                ->action(function ()
                    {
                        (new BrowserProfileServices)->update();
                        \Filament\Notifications\Notification::make()
                        ->title('Successfully')
                        ->success()
                        ->send();
                    }
                ),
        ];
    }
}
