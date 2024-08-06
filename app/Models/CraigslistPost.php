<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CraigslistPost extends Model
{
    use HasFactory;

    protected $guarded = false;

    const PATH = "/assets/craigslist_post/preview/";
    const DEFULT_PREVIEW = "svoditelem_img.png";

    protected function preview(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Controller::photoAccessor($value, self::PATH),
            // set: fn ($value) => $this->setPhotoAccessor($value),
        );
    }

    public function browser_profile()
    {
        return $this->hasOne(BrowserProfile::class, 'id', 'browser_profile_id');
    }

    public function post_scheduleds(): MorphMany
    {
        return $this->morphMany(PostScheduled::class, 'post');
    }
}
