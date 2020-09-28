<?php

namespace Rockbuzz\LaraTags\Models;

use Rockbuzz\LaraUuid\Traits\Uuid;
use Spatie\Sluggable\{HasSlug, SlugOptions};
use Illuminate\Database\Eloquent\{Model, Builder};
use Spatie\SchemalessAttributes\SchemalessAttributes;

class Tag extends Model
{
    use Uuid, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'metadata',
        'order_column'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
        'metadata' => 'array'
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getMetadataAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'metadata');
    }

    public function scopeWithMetadata(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('metadata');
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
