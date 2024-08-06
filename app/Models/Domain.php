<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = ['namecheap_account', 'namecheap_domain_id', 'namecheap_domain_name', 'namecheap_created',
        'namecheap_expires', 'namecheap_is_expired', 'namecheap_is_locked', 'namecheap_is_autorenew'];
}
