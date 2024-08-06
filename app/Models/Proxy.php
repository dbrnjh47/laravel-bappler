<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProxyConnection;

class Proxy extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function connection()
    {
        return $this->hasOne(ProxyConnection::class, 'proxy_id', 'id');
    }

    public function provider()
    {
        return $this->hasOne(ProxyProvider::class, 'id', 'proxy_provider_id');
    }

    public function browser_profiles()
    {
        return $this->hasMany(BrowserProfile::class, 'proxy_id', 'id');
    }
}
