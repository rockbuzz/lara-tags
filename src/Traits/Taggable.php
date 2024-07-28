<?php

namespace Rockbuzz\LaraTags\Traits;

use Rockbuzz\LaraTags\Models\Tag;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Taggable
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(config('tags.models.tag'), 'taggable');
    }

    public function tagsWithType(string $type): Collection
    {
        return $this->tags->filter(static fn(Tag $tag) => $tag->type === $type)->values();
    }

    public function hasTag($tag): bool
    {
        return $this->tags->contains('id', $this->resolveTagId($tag));
    }

    public function scopeWithAnyTags(Builder $builder, array $tags, string $type = null): Builder
    {
        $validatedTagsIds = collect($tags)->filter(fn(Tag|int|string $tag) => $this->resolveTagId($tag))->values();

        return $builder->whereHas('tags', static fn(Builder $builder) => $builder
            ->whereIn('tags.id', $validatedTagsIds)
            ->when($type, static fn(Builder $builder, string $type) => $builder
                ->where('tags.type', $type)));
    }

    private function resolveTagId(Tag|int|string $tag): ?int
    {
        if (is_a($tag, Tag::class)) {
            return $tag->id;
        }

        if (is_int($tag)) {
            return $tag;
        }

        return Tag::where('name', $tag)->first()?->id;
    }
}