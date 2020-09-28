<?php

namespace Rockbuzz\LaraTags\Traits;

use Ramsey\Uuid\Uuid;
use Rockbuzz\LaraTags\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

trait Taggable
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

    public function scopeWithAnyTags(Builder $query, array $tags, string $type = null): Builder
    {
        $validatedTags = [];
        foreach ($tags as $tag) {
            if (is_a($tag, Tag::class)) {
                $validatedTags[] = $tag;
                continue;
            }
            if (Uuid::isValid($tag) and $validTag = Tag::find($tag)) {
                $validatedTags[] = $validTag;
                continue;
            }
            if ($validTag = Tag::whereName($tag)->first()) {
                $validatedTags[] = $validTag;
            }
        }

        return $query->whereHas('tags', function (Builder $query) use ($validatedTags, $type) {
            $tagIds = collect($validatedTags)->pluck('id');

            $query->whereIn('tags.id', $tagIds);

            if ($type) {
                $query->where('tags.type', $type);
            }
        });
    }
}
