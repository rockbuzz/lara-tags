<?php

namespace Rockbuzz\LaraTags\Traits;

use Rockbuzz\LaraTags\Models\Tag;

trait Taggables
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tagsWithType(string $type)
    {
        return $this->tags->filter(function (Tag $tag) use ($type) {
            return $tag->type === $type;
        });
    }
}
