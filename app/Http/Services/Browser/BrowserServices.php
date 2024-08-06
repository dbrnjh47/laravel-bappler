<?php

namespace App\Http\Services\Browser;

use App\Http\Services\Browser\API\AdsPowerApi;


class BrowserServices
{
    public function index()
    {
        (new BrowserGroupServices)->update();
        // sleep(1);
        (new BrowserProfileServices)->update();
        return;
    }
}
