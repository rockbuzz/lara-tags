<?php

namespace Tests;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Sluggable\HasSlug;
use Rockbuzz\LaraTags\Models\Tag;
use Rockbuzz\LaraUuid\Traits\Uuid;
use Tests\Stubs\Article;

class TaggablesTest extends TestCase
{
    public function testTags()
    {
        $article = Article::create(['name' => 'any_name']);

        $this->assertInstanceOf(MorphToMany::class, $article->tags());
    }

    public function testTagsWithType()
    {
        $tagA = Tag::create(['name' => 'any_name', 'type' => 'typeA']);
        $tagB = Tag::create(['name' => 'any_name', 'type' => 'typeB']);

        $article = Article::create(['name' => 'any_name']);

        $article->tags()->sync([$tagA->id, $tagB->id]);

        $this->assertCount(1, $article->tagsWithType('typeA'));
        $this->assertCount(1, $article->tagsWithType('typeB'));
        $this->assertCount(0, $article->tagsWithType('typeC'));
    }
}
