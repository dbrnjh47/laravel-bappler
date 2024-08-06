<?php

namespace App\Filament\Resources\ProxyProviderResource\Pages;

use Filament\Actions;
use Filament\Forms\Set;
use Filament\Resources\Pages\EditRecord;
use App\Http\Services\Proxy\ProxyServices;
use App\Filament\Resources\ProxyProviderResource;
use Filament\Notifications\Notification;

class EditProxyProvider extends EditRecord
{
    protected static string $resource = ProxyProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('Update balance')
                ->color("gray")
                ->requiresConfirmation()
                ->action(function ($record, $livewire)
                    {
                        (new ProxyServices)->update($record, 0);
                        $livewire->refreshFormData(['balance']);
                        // https://github.com/filamentphp/filament/discussions/8274

                        Notification::make()
                        ->title('Successfully')
                        ->success()
                        ->send();
                    }
                ),
            Actions\Action::make('Update')
                ->color("gray")
                ->requiresConfirmation()
                ->action(function ($record, $livewire)
                    {
                        (new ProxyServices)->update($record);
                        $livewire->refreshFormData(['balance']);
                        // https://github.com/filamentphp/filament/discussions/8274
                        // $livewire->dispatch('update-record');

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
            ProxyProviderResource\Widgets\ProxyProviderShowOverview::class,
        ];
    }
}
