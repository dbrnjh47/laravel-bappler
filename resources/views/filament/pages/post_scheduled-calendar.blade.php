<x-filament-panels::page>
    {{-- <div id='conteinerLists'>
        <p>
            <strong>Draggable Events</strong>
        </p>

        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>My Event 1</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>My Event 2</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>My Event 3</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>My Event 4</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
            <div class='fc-event-main'>My Event 5</div>
        </div>

        <a tabindex="0" style="width: 50px" class="fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future fc-daygrid-event fc-daygrid-block-event fc-h-event"><div class="fc-event-main"><div class="fc-event-main-frame"><div class="fc-event-title-container"><div class="fc-event-title fc-sticky">test7</div></div></div></div><div class="fc-event-resizer fc-event-resizer-end"></div></a>

        <p>
            <input type='checkbox' id='drop-remove' />
            <label for='drop-remove'>remove after drop</label>
        </p>
    </div> --}}

    <style>
        .fc-event {
            height: 50px;
        }

        .fc-event .fc-event-main {
            height: 100%;
        }

        .fc-event .fc-event-main>div {
            display: flex;
            width: 100%;
            overflow: hidden;
            height: 100%;
            overflow-wrap: normal;
            text-wrap: balance;
            line-height: 17px;
            font-size: 12px;
        }

        .fc-event .fc-event-main img,
        .fc-list-event-title img {
            width: 35px;
            height: 35px;
            margin-right: 5px;
            border-radius: 100%;
        }
    </style>

    @include('filament.components.tabs')

    {{-- @livewire('post_scheduled.filter.select-post') --}}

    @livewire(\App\Filament\Widgets\PostScheduledCalendarWidget::class)

    {{-- <script src="/js/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('conteinerLists');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        allDay: true
                    };
                }
            });

        });
    </script> --}}
</x-filament-panels::page>
