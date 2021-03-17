<?php

namespace Tests;

use Spatie\Sluggable\HasSlug;
use Rockbuzz\LaraTags\Models\Tag;
use Illuminate\Support\Facades\Config;

class TagTest extends TestCase
{
    protected $tag;

    public function setUp(): void
    {
        parent::setUp();

        $this->tag = new Tag();
    }

    public function test_if_uses_taits()
    {
        $expected = [
            HasSlug::class
        ];

        $this->assertEquals(
            $expected,
            array_values(class_uses(Tag::class))
        );
    }

    public function test_fillable()
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

    public function test_casts()
    {
        $expected = [
            'id' => 'int',
            'metadata' => 'array'
        ];

        $this->assertEquals($expected, $this->tag->getCasts());
    }

    public function test_route_key_name()
    {
        $this->assertEquals('slug', $this->tag->getRouteKeyName());

        Config::set('tags.route_key_name', 'id');

        $this->assertEquals('id', $this->tag->getRouteKeyName());
    }

    public function test_scope_type()
    {
        $nullTag = Tag::create(['name' => 'any_name', 'type' => null]);
        $typeATag = Tag::create(['name' => 'any_name', 'type' => 'typeA']);

        $this->assertContains($nullTag->id, Tag::type(null)->get()->pluck('id'));
        $this->assertNotContains($typeATag->id, Tag::type(null)->get()->pluck('id'));
        $this->assertNotContains($nullTag->id, Tag::type('not_exists')->get()->pluck('id'));
        $this->assertContains($typeATag->id, Tag::type('typeA')->get()->pluck('id'));
        $this->assertNotContains($nullTag->id, Tag::type('typeA')->get()->pluck('id'));
    }

    public function test_find_from_slug()
    {
        $nullTag = Tag::create(['name' => 'any name', 'type' => null]);
        $typeATag = Tag::create(['name' => 'any name a', 'type' => 'typeA']);

        $this->assertInstanceOf(Tag::class, Tag::findFromSlug('any-name'));
        $this->assertNull(Tag::findFromSlug('any-name-a'));
        $this->assertInstanceOf(Tag::class, Tag::findFromSlug('any-name-a', 'typeA'));
    }
}
