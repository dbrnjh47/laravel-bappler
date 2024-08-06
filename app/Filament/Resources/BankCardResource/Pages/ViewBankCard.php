<?php

namespace App\Filament\Resources\BankCardResource\Pages;

use App\Filament\Resources\BankCardResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBankCard extends ViewRecord
{
    protected static string $resource = BankCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
