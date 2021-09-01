<?php

namespace Rockbuzz\LaraTags\Traits;

use Exception;
use Rockbuzz\LaraTags\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            return $this->tags->contains('id', $this->resolveTag($tag)->id);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return false;
    }

    public function scopeWithAnyTags(Builder $query, array $tags, string $type = null): Builder
    {
        $validatedTags = collect($tags)->reduce(function ($validatedTags, $tag) {
            try {
                $validatedTags[] = $this->resolveTag($tag);
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
            return $validatedTags;
        }, []);

        return $query->whereHas('tags', function (Builder $query) use ($validatedTags, $type) {
            $tagIds = collect($validatedTags)->pluck('id');

            $query->whereIn('tags.id', $tagIds);

            if ($type) {
                $query->where('tags.type', $type);
            }
        });
    }

    /**
     * @param Tag|string|int $tag model, name or id
     * @return Tag
     * @throws ModelNotFoundException
     */
    private function resolveTag($tag): Tag
    {
        if (is_a($tag, Tag::class)) {
            return $tag;
        }

        if (is_int($tag)) {
            return  Tag::findOrFail($tag);
        }

        return Tag::whereName($tag)->firstOrFail();
    }
}
