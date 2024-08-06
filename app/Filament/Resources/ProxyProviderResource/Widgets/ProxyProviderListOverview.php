<?php

namespace App\Filament\Resources\ProxyProviderResource\Widgets;

use App\Http\Services\Proxy\ProxyServices;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Http\Services\Proxy\ProxyProviderServices;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProxyProviderListOverview extends BaseWidget
{
    public function getColumns(): int
    {
        return 2;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Count', (new ProxyProviderServices)->count()),
            Stat::make('Count Proxies', (new ProxyServices)->count()),
        ];
    }
}
