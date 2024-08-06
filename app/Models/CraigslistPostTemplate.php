<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CraigslistPostTemplate extends Model
{
    use HasFactory;

    protected $guarded = false;

    const PATH = "/assets/craigslist_post_temple/preview/";
    const DEFULT_PREVIEW = "svoditelem_img.png";

    protected function preview(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Controller::photoAccessor($value, self::PATH),
            // set: fn ($value) => $this->setPhotoAccessor($value),
        );
    }

    public function bank_card()
    {
        return $this->hasOne(BankCard::class, 'id', 'bank_card_id');
    }

    public function browser_profile()
    {
        return $this->hasOne(BrowserProfile::class, 'id', 'browser_profile_id');
    }
}
