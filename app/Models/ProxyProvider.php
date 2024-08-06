<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxyProvider extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function proxies()
    {
        return $this->hasMany(Proxy::class, 'proxy_provider_id', 'id');
    }
}
