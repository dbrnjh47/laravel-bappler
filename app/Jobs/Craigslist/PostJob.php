<?php

namespace App\Jobs\Craigslist;

use App\Http\Services\Craigslist\CraigslistServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post_id;

    /**
     * Create a new job instance.
     */
    public function __construct($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new CraigslistServices)->post($this->post_id);
    }
}
