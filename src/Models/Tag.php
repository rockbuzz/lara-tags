<?php

namespace Rockbuzz\LaraTags\Models;

use Spatie\Sluggable\{HasSlug, SlugOptions};
use Illuminate\Database\Eloquent\{Builder, Model};

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

    public function getRouteKeyName(): string
    {
        return config('tags.route_key_name');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeType(Builder $builder, $type): Builder
    {
        return $builder->where('type', $type);
    }

    public static function findFromSlug(string $slug, string $type = null): ?static
    {
        return static::where('slug', $slug)->where('type', $type)->first();
    }
}