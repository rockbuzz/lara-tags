<?php

namespace Tests;

use Tests\Stubs\Article;
use Rockbuzz\LaraTags\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        Tag::create(['name' => 'any_name', 'type' => 'typeC']);

        $article = Article::create(['name' => 'any_name']);

        $article->tags()->sync([$tagA->id, $tagB->id]);

        $this->assertCount(1, $article->tagsWithType('typeA'));
        $this->assertCount(1, $article->tagsWithType('typeB'));
        $this->assertCount(0, $article->tagsWithType('typeC'));
        $this->assertCount(0, $article->tagsWithType('NotExists'));
    }

    public function testHasTag()
    {
        $tagA = Tag::create(['name' => 'tagA']);
        $tagB = Tag::create(['name' => 'tagB']);

        $article = Article::create(['name' => 'any_name']);

        $article->tags()->attach($tagA->id);

        $this->assertTrue($article->hasTag('tagA'));
        $this->assertTrue($article->hasTag($tagA));
        $this->assertFalse($article->hasTag('tagB'));
        $this->assertFalse($article->hasTag($tagB));
        $this->assertFalse($article->hasTag('NotExists'));
    }

    public function testWithAnyTags()
    {
        $tagA = Tag::create(['name' => 'tagA']);
        $tagB = Tag::create(['name' => 'tagB']);

        $article = Article::create(['name' => 'any_name']);

        $article->tags()->attach($tagA->id);

        $this->assertContains($article->id, $article->withAnyTags(['tagA'])->get()->pluck('id'));
        $this->assertContains($article->id, $article->withAnyTags([$tagA])->get()->pluck('id'));
        $this->assertContains($article->id, $article->withAnyTags([$tagA->id])->get()->pluck('id'));
        $this->assertNotContains($article->id, $article->withAnyTags(['tagB'])->get()->pluck('id'));
    }

    public function testWithAnyTagsType()
    {
        $tagA = Tag::create(['name' => 'tagA', 'type' => 'typeA']);
        $tagB = Tag::create(['name' => 'tagB', 'type' => 'typeB']);

        $article = Article::create(['name' => 'any_name']);

        $article->tags()->attach($tagA->id);

        $this->assertContains($article->id, $article->withAnyTags(['tagA'], 'typeA')->get()->pluck('id'));
        $this->assertNotContains($article->id, $article->withAnyTags(['tagA'], 'typeB')->get()->pluck('id'));
    }
}
