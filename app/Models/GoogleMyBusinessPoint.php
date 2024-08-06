<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleMyBusinessPoint extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'address', 'open_hours', 'phone', 'adspower_profile_id', 'organization_google_maps_url', 'domain_id', 'email_id'];

    /**
     * Get the domain that owns the google my business point.
     */
    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function email(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Email::class, 'email_id', 'id');
    }
}
