<?php

namespace Tests\Stubs;

use Rockbuzz\LaraUuid\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Rockbuzz\LaraTags\Traits\Taggables;

class Article extends Model
{
    use Uuid, Taggables;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];
}
