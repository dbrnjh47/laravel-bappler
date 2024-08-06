<?php

namespace App\Filament\Resources\ProxyProviderResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;


class ProxyProviderShowOverview extends BaseWidget
{
    public ?Model $record = null;

    protected int|string|array $columnSpan = 'full';
    public function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Balance', (new \NumberFormatter('en', \NumberFormatter::CURRENCY))->formatCurrency($this->record->balance, 'USD')),
            Stat::make('Count Proxy', $this->record->proxies()->count()),
        ];
    }
}
