<?php

namespace Tests\Stubs;

use Rockbuzz\LaraTags\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Taggable;

    protected $guarded = [];
}
