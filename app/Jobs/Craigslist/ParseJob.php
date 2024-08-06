<?php

namespace App\Jobs\Craigslist;

use App\Http\Services\Craigslist\CraigslistServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $browser_profile;

    /**
     * Create a new job instance.
     */
    public function __construct($browser_profile)
    {
        $this->browser_profile = $browser_profile;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new CraigslistServices)->parse($this->browser_profile);
    }
}
