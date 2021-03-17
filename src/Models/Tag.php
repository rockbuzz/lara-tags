<?php

namespace Rockbuzz\LaraTags\Models;

use Spatie\Sluggable\{HasSlug, SlugOptions};
use Illuminate\Database\Eloquent\{Model, Builder};

class Tag extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'metadata',
        'order_column'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function getRouteKeyName()
    {
        return config('tags.route_key_name');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeType($query, $type)
    {
        return $query->whereType($type);
    }

    public static function findFromSlug(string $slug, $type = null)
    {
        return static::whereSlug($slug)->whereType($type)->first();
    }
}
