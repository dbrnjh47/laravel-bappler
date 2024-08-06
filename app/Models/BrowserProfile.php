<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrowserProfile extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function group()
    {
        return $this->hasOne(BrowserGroup::class, 'id', 'browser_group_id');
    }

    public function proxy()
    {
        return $this->hasOne(Proxy::class, 'id', 'proxy_id');
    }

    public function posts()
    {
        return $this->hasMany(CraigslistPost::class, 'browser_profile_id', 'id');
    }
}
