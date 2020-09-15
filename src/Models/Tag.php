<?php

namespace Rockbuzz\LaraActivities\Models;

use Rockbuzz\LaraUuid\Traits\Uuid;
use Illuminate\Database\Eloquent\{Model, Builder};
use Spatie\SchemalessAttributes\SchemalessAttributes;

class Tag extends Model
{
    use Uuid;

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

    public function getMetadataAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'metadata');
    }

    public function scopeWithMetadata(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('metadata');
    }
}
