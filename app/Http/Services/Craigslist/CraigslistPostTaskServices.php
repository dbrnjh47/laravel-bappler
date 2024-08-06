<?php

namespace App\Http\Services\Craigslist;

use App\Models\CraigslistPostTask;
use Carbon\Carbon;

class CraigslistPostTaskServices
{
    public function create($data)
    {
        // $start_at = Carbon::parse($data["scheduled_start_date"]);
        // $end_at = Carbon::parse($data["scheduled_end_date"]);

        return CraigslistPostTask::create($data);
    }
}
