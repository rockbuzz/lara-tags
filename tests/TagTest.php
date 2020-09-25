<?php

namespace Tests;

use Spatie\Sluggable\HasSlug;
use Rockbuzz\LaraTags\Models\Tag;
use Rockbuzz\LaraUuid\Traits\Uuid;

class TagTest extends TestCase
{
    protected $tag;

    public function setUp(): void
    {
        parent::setUp();

        $this->tag = new Tag();
    }

    public function testIfUsesTraits()
    {
        $expected = [
            Uuid::class,
            HasSlug::class
        ];

        $this->assertEquals(
            $expected,
            array_values(class_uses(Tag::class))
        );
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->tag->incrementing);
    }

    public function testKeyType()
    {
        $this->assertEquals('string', $this->tag->getKeyType());
    }

    public function testFillable()
    {
        $expected = [
            'name',
            'slug',
            'type',
            'metadata',
            'order_column'
        ];

        $this->assertEquals($expected, $this->tag->getFillable());
    }

    public function testCasts()
    {
        $expected = [
            'id' => 'string',
            'metadata' => 'array'
        ];

        $this->assertEquals($expected, $this->tag->getCasts());
    }

    public function testScopeType()
    {
        $nullTag = Tag::create(['name' => 'any_name', 'type' => null]);
        $typeATag = Tag::create(['name' => 'any_name', 'type' => 'typeA']);

        $this->assertContains($nullTag->id, Tag::type(null)->get()->pluck('id'));
        $this->assertNotContains($typeATag->id, Tag::type(null)->get()->pluck('id'));
        $this->assertNotContains($nullTag->id, Tag::type('not_exists')->get()->pluck('id'));
        $this->assertContains($typeATag->id, Tag::type('typeA')->get()->pluck('id'));
        $this->assertNotContains($nullTag->id, Tag::type('typeA')->get()->pluck('id'));
    }
}
