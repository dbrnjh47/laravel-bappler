<?php

namespace App\Filament\Resources\ProxyProviderResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Http\Services\Proxy\ProxyServices;
use App\Filament\Resources\ProxyProviderResource;
use Filament\Notifications\Notification;

class ListProxyProviders extends ListRecords
{
    protected static string $resource = ProxyProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Update')
                ->color("gray")
                ->requiresConfirmation()
                ->action(function ()
                    {
                        (new ProxyServices)->updateAll();
                        Notification::make()
                        ->title('Successfully')
                        ->success()
                        ->send();
                    }
                ),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProxyProviderResource\Widgets\ProxyProviderListOverview::class,
        ];
    }
}
