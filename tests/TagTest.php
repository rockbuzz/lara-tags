<?php

namespace Tests;

use Rockbuzz\LaraTags\Models\Tag;
use Rockbuzz\LaraUuid\Traits\Uuid;
use Spatie\Sluggable\{HasSlug, SlugOptions};

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
}
