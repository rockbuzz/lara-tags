<?php

namespace Tests\Stubs;

use Rockbuzz\LaraUuid\Traits\Uuid;
use Rockbuzz\LaraTags\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Uuid, Taggable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];
}
