<?php

namespace App\Filament\Resources\RequestResource\Widgets;

use App\Filament\Resources\RequestResource\Pages\ListRequests;
use App\Models\Request;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class RequestsChart extends ChartWidget
{
    use InteractsWithPageTable;

    protected static ?string $heading = 'Visits Statistics';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $startDate = Carbon::parse($this->tableFilters['created_at']['created_from']) ?? null;
        $endDate = Carbon::parse($this->tableFilters['created_at']['created_until'])->addDay() ?? null;
        $domainId = $this->tableFilters['Domain']['value'] ?? null;
        //$domain = $this->tableFilters
        //dump($this->tableFilters);
        //dump($startDate);
        //dump($endDate);

        $data = Trend::query(
                Request::query()
                    ->when($domainId, fn(Builder $query) => $query->where('domain_id', $domainId))
                    ->when($startDate, fn (Builder $query) => $query->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn (Builder $query) => $query->whereDate('created_at', '<', $endDate))
            )
            ->between(
                start: !is_null($startDate) ? $startDate : now()->subMonth(),
                end: !is_null($endDate) ? $endDate : now(),
            )
            ->perDay()
            ->count();

        /*
        $data = Trend::model(Request::class)
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();
        */

        return [
            'datasets' => [
                [
                    'label' => 'Visits',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getTablePage(): string
    {
        return ListRequests::class;
    }
}
