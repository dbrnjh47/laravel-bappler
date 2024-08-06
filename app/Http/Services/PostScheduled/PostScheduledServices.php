<?php

namespace App\Http\Services\PostScheduled;

use App\Http\Services\Craigslist\CraigslistServices;
use App\Jobs\Craigslist\CreateJob;
use App\Jobs\Craigslist\PostJob;
use App\Models\PostScheduled;

use Carbon\Carbon;
use Error;

class PostScheduledServices
{
    public function scheduler()
    {
        // $now = Carbon::parse("2024-06-14 18:10:00");
        // $now_end = Carbon::parse("2024-06-14 18:10:00")->addMinute();

        $now = Carbon::now();
        // $now_end = Carbon::now()->addMinute();

        $auto_posts = PostScheduled::whereDate("scheduled_start_date", "<=", $now)
            ->whereDate("scheduled_end_date", ">=", $now)
            ->where('start_time', '>=', "{$now->hour}:{$now->minute}:00")
            // ->where('end_time', '<=', "{$now->hour}:{$now->minute}:00")
            ->get();
        // dd($auto_posts);
        if (count($auto_posts)) {
            foreach ($auto_posts as $auto_post) {
                $this->post($auto_post);
            }
        }
        return;
    }

    public function post($auto_post)
    {
        switch ($auto_post->post_type) {
            case 'App\Models\CraigslistPostTemplate':
                dispatch(new CreateJob($auto_post->post_id));
                break;
        }
    }

    public function update($record, $data)
    {
        $record->update($data);
    }

    public function create($data, $start_day = 1)
    {
        if (isset($data["id"])) {
            PostScheduled::create($data);
            return;
        }

        switch ($data['schedule_type']) {
            case "random":
                $this->createRandom($data, $start_day);
                break;

            default:
                $this->createDays($data, $start_day);
                break;
        }
    }

    protected function createDays($data, $start_day)
    {
        $start_at = Carbon::parse($data['scheduled_start_date']);
        $end_at = Carbon::parse($data['scheduled_end_date']);
        $days = $start_at->diffInDays($end_at);

        for ($i = $start_day; $i <= $days; $i++) {
            if ($i != 0) {
                $start_at->addDay();
            }

            $data["scheduled_start_date"] = $start_at;
            $data["scheduled_end_date"] = $start_at;

            PostScheduled::create($data);
        }
    }

    protected function createRandom($data, $start_day)
    {
        $start_at = Carbon::parse($data['scheduled_start_date']);
        $end_at = Carbon::parse($data['scheduled_end_date']);
        $days = $start_at->diffInDays($end_at);
        $col = $data['posts_quantity'];
        if ($col > $days) {
            $col = $days;
        }

        if ($start_day != 0) {
            $start_at = $start_at->addDay();
            $col = $col - $start_day;
        }

        if($col <= 0){return;}

        $randomDates = $this->getRandomDatesFromPeriod($start_at, $end_at, $col);

        foreach ($randomDates as $date) {
            $data["scheduled_start_date"] = $date;
            $data["scheduled_end_date"] = $date;

            PostScheduled::create($data);
        }
    }

    public function getRandomDatesFromPeriod(Carbon $startDate, Carbon $endDate, int $count = 4): array
    {
        $dates = [];
        $interval = $endDate->diffInDays($startDate);

        if ($count > $interval) {
            throw new \Exception("Количество дат не может быть больше, чем количество дней в периоде");
        }

        $randomDays = array_rand(range(0, $interval), $count);
        foreach ($randomDays as $randomDay) {
            $dates[] = $startDate->copy()->addDays($randomDay);
        }

        sort($dates);

        return $dates;
    }

    public function find($id)
    {
        return PostScheduled::findOrFail($id);
    }
}
