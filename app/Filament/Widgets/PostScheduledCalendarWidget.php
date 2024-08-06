<?php

namespace App\Filament\Widgets;

// use Filament\Widgets\Widget;

use App\Filament\Pages\PostScheduledCalendar;
use App\Filament\Resources\CraigslistPostTemplateResource;
use App\Models\PostScheduled;
use App\Models\CraigslistPostTemplate;
use App\Filament\Resources\CraigslistPostResource;
use App\Models\CraigslistPost;
use App\Models\Domain;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Builder;

class PostScheduledCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = PostScheduled::class;
    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */

    public function config(): array
    {
        return [
            // 'firstDay' => 1,
            "editable" => false,
            "eventStartEditable" => true,
            'headerToolbar' => [
                'left' => 'dayGridDay,dayGridWeek,dayGridMonth,dayGridYear,listMonth',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
            'eventMinHeight' => 50000,
            'droppable' => true,
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        // dd(rand(1,111111111));
        // https://fullcalendar.io/docs/event-parsing
        return PostScheduled::with('post')
            ->with('task')
            ->whereHas('task', function ($q) use ($fetchInfo) {
                $q = $q->where('scheduled_start_date', '>=', $fetchInfo['start']);
                $q = $q->where('scheduled_start_date', '<=', $fetchInfo['end']);
            })
            // ->where('scheduled_start_date', '>=', $fetchInfo['start'])
            // ->where('scheduled_start_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (PostScheduled $auto_post) {
                return [
                    'id'    => $auto_post->id,
                    'title' => "<div> <img src=\"{$auto_post->post->preview}\" /><div style=\"white-space: break-spaces;\"><p>{$auto_post->task->start_time} - {$auto_post->task->end_time}</p> {$auto_post->post->title}</div></div>",
                    'start' => $auto_post->task->scheduled_start_date,
                    'end' => $auto_post->task->scheduled_end_date,
                    'allDay' => 1,
                    'URL' => null,
                    // 'plagins' ['scrollGrid']
                ];
            })
            ->toArray();
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make()
                ->form($this->getFormSchema())
                ->action(function ($record, array $data) {
                    $record->update($data);

                    return redirect(PostScheduledCalendar::getUrl());
                }),

            DeleteAction::make()
            ->action(function ($record, array $data) {
                $record->delete();

                return redirect(PostScheduledCalendar::getUrl());
            }),

            Action::make('View temple')
                ->color("gray")
                ->url(function ($record, $livewire) {
                    switch($record->post_type)
                    {
                        case "App\Models\CraigslistPostTemplate":
                            return CraigslistPostTemplateResource::getUrl('view', ['record' => $record->post_id]);

                        default:
                            return CraigslistPostResource::getUrl('view', ['record' => $record->post_id]);
                    }
                })
                ->openUrlInNewTab(),
        ];
    }

    // https://github.com/saade/filament-fullcalendar/issues/122
    protected function getFormModel(): Model|string|null
    {
        return $this->event ?? PostScheduled::class;
    }

    public function resolveEventRecord(array $data): PostScheduled
    {
        return PostScheduled::find($data['id']);
    }

    public function getFormSchema(): array
    {
        return [
            // \Filament\Forms\Components\TextInput::make('title')->readOnly(),
            // \Filament\Forms\Components\MorphToSelect::make('post_id')
            //     // ->options([
            //     //     'In Process' => $this->,
            //     //     'Reviewed' => [
            //     //         'published' => 'Published',
            //     //         'rejected' => 'Rejected',
            //     //     ],
            //     // ])
            //     // ->relationship(
            //     //     name: 'post',
            //     //     modifyQueryUsing: fn (Builder $query) => $query,
            //     // )
            //     // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->time} {$record->post->title}")

            //     ->types([
            //         \Filament\Forms\Components\MorphToSelect\Type::make(CraigslistPost::class)
            //             ->titleAttribute('title'),

            //     ])
            //     ->native(0)
            //     ->searchable()
            //     ->preload(),

            \Filament\Forms\Components\MorphToSelect::make('post')
                ->types([
                    // \Filament\Forms\Components\MorphToSelect\Type::make(CraigslistPost::class)
                    // ->titleAttribute('title'),
                    \Filament\Forms\Components\MorphToSelect\Type::make(CraigslistPostTemplate::class)
                        ->titleAttribute('title'),
                    // \Filament\Forms\Components\MorphToSelect\Type::make(CraigslistPost::class)
                    //     ->titleAttribute('id'),
                ])
                ->native(0)
                ->preload()
                ->searchable(),



            // \Filament\Forms\Components\Select::make('post_id')
            //     ->relationship(name: 'craigslistPostTemplate', titleAttribute: 'title')
            //     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id} - {$record->title}")
            //     ->native(0)
            //     ->searchable(['title'])
            //     ->preload()
            //     ->required(),

            \Filament\Forms\Components\DatePicker::make('scheduled_start_date')
                ->default(now())
                ->beforeOrEqual('scheduled_end_date')
                ->required(),
            \Filament\Forms\Components\DatePicker::make('scheduled_end_date')
                ->default(Carbon::now()->endOfMonth())
                ->required(),
            \Filament\Forms\Components\TimePicker::make('start_time')
                ->required(),
            \Filament\Forms\Components\TimePicker::make('end_time')
                ->required(),


            \Filament\Forms\Components\TextInput::make('posts_quantity')
                ->numeric()
                ->default(1)
                ->maxValue(100)
                ->minValue(1)
                ->required(),
            \Filament\Forms\Components\Select::make('schedule_type')
                ->options([
                    'random' => 'Random',
                    'days' => 'Days',
                    'time' => 'Time',
                ])
                ->required()
        ];
    }

    // https://github.com/saade/filament-fullcalendar/blob/3.x/src/Widgets/Concerns/InteractsWithEvents.php
    // public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    // {
    //     if ($this->getModel()) {
    //         $this->record = $this->resolveRecord($event['id']);
    //     }

    //     $this->mountAction('edit', [
    //         'type' => 'resize',
    //         'event' => $event,
    //         'oldEvent' => $oldEvent,
    //         'relatedEvents' => $relatedEvents,
    //         'startDelta' => $startDelta,
    //         'endDelta' => $endDelta,
    //     ]);

    //     return false;
    // }

    public function onEventClick(array $event): void
    {
        if ($this->getModel()) {
            $this->record = $this->resolveRecord($event['id']);
        }

        $this->mountAction('view', [
            'type' => 'click',
            'event' => $event,
        ]);
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        if ($this->getModel()) {
            $this->record = $this->resolveRecord($event['id']);
        }

        $this->record->task->scheduled_start_date = Carbon::parse($event['start']);
        $this->record->task->scheduled_end_date = Carbon::parse($event['start']);
        $this->record->task->save();

        $this->record->scheduled_start_date = Carbon::parse($event['start']);
        $this->record->scheduled_end_date = Carbon::parse($event['start']);
        $this->record->save();


        return false;
    }

    public function onEventResize(array $event, array $oldEvent, array $relatedEvents, array $startDelta, array $endDelta): bool
    {
        if ($this->getModel()) {
            $this->record = $this->resolveRecord($event['id']);
        }

        $this->record->task->scheduled_start_date = Carbon::parse($event['start']);
        $this->record->task->scheduled_end_date = Carbon::parse($event['end']);
        $this->record->task->save();

        $this->record->scheduled_start_date = Carbon::parse($event['start']);
        $this->record->scheduled_end_date = Carbon::parse($event['end']);
        $this->record->save();

        return false;
    }

    public static function canView(): bool
    {
        return false;
    }

    public function eventContent(): string
    {
        return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){

            return {
                html: event.title
            };
        }
    JS;
    }
}
