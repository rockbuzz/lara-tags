<?php

namespace Rockbuzz\LaraTags\Traits;

use Rockbuzz\LaraTags\Models\Tag;

trait Taggables
{
    public function tags()
    {
        return $this->morphToMany(config('tags.models.tag'), 'taggable');
    }

    public function tagsWithType(string $type)
    {
        return $this->tags->filter(function (Tag $tag) use ($type) {
            return $tag->type === $type;
        });
    }

    public function hasTag($tag)
    {
        if (is_a($tag, Tag::class)) {
            return $this->tags->contains('id', $tag->id);
        }
        if ($tag = Tag::whereName($tag)->first()) {
            return $this->tags->contains('id', $tag->id);
        }
        return false;
    }
}
