<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = ['domain_id', 'ip_address', 'http_user_agent', 'http_user_language', 'UTM'];

    protected $casts = [
        'UTM' => 'json',
    ];

    /**
     * Get the domain that owns the request.
     */
    public function domain(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }
}
