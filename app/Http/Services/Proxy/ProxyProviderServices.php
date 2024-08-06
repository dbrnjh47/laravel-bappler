<?php

namespace App\Http\Services\Proxy;

use App\Models\ProxyProvider;

class ProxyProviderServices
{
    public function get()
    {
        return ProxyProvider::get();
    }

    public function count()
    {
        return ProxyProvider::count();
    }
}
