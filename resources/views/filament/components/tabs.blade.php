<style>
    .tabs {
        display: flex;
        justify-content: center;
    }

    .tabs .tab {
        padding: 10px;
        background: #1d1d1f;
        border-radius: 8px;
        font-weight: 700;
        margin: 5px;
        transition: all 0.5s
    }

    .tabs .tab:hover {
        opacity: 0.7;
    }
</style>
<div class="tabs">
    <a href="{{\App\Filament\Pages\PostScheduledCalendar::getUrl()}}" class="tab">Post Schedule</a>
    <a href="{{\App\Filament\Resources\CraigslistPostTaskResource::getUrl()}}" class="tab">Craigslist Tasks</a>
</div>
