<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdomain extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'title',
        'slug',
        'url',
        'short_description',
        'long_description',
        'category',
        'tags',
        'is_active',
        'is_highlighted',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'is_highlighted' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(SubdomainImage::class)->orderBy('sort_order');
    }

    public function thumbnail(): ?string
    {
        return $this->images->first()?->image_url;
    }
}
