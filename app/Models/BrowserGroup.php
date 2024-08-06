<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrowserGroup extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function profiles()
    {
        return $this->hasMany(BrowserProfile::class, 'browser_group_id', 'id');
    }
}
