<?php

namespace App\Http\Controllers\Craigslist;

use App\Http\Controllers\Controller;
use App\Jobs\Craigslist\ParseJob;
use App\Jobs\Craigslist\PostJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


class CraigslistController extends Controller
{
    public function parse($browser_profile)
    {
        dispatch(new ParseJob($browser_profile));
        return ;
    }

    public function post($post_id)
    {
        dispatch(new PostJob($post_id));
        return ;
    }
}
