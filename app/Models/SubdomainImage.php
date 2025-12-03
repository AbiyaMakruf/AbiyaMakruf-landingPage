<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubdomainImage extends Model
{
    protected $fillable = [
        'subdomain_id',
        'image_url',
        'caption',
        'sort_order',
    ];

    public function subdomain(): BelongsTo
    {
        return $this->belongsTo(Subdomain::class);
    }
}
