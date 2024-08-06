<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleMyBusinessReview extends Model
{
    use HasFactory;

    protected $fillable = ['google_my_business_point_id', 'name', 'date_published', 'stars', 'text'];

    /*protected $casts = [
        'images' => 'array',
    ];*/

    /**
     * Get the domain that owns the google my business point.
     */
    public function google_account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(GoogleMyBusinessPoint::class, 'google_my_business_point_id', 'id');
    }
}
