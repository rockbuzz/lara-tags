<?php

namespace Rockbuzz\LaraTags\Traits;

use Rockbuzz\LaraTags\Models\Tag;

trait Taggables
{
    public function tags(string $type = null)
    {
        $builder = $this->hasMany(Tag::class);

        if ($type) {
            $builder->where('type', $type);
        }

        return $builder;
    }
}
