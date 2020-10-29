# Lara Tags

Tag management

<p><img src="https://github.com/rockbuzz/lara-tags/workflows/Main/badge.svg"/></p>

## Requirements

PHP >=7.2

## Install

```bash
$ composer require rockbuzz/lara-tags
```

```php
$ php artisan vendor:publish --provider="Rockbuzz\LaraTags\ServiceProvider" --tag="migrations"
```

```php
$ php artisan migrate
```

Add the `Taggable` trait to the template for which you will have tags

```php
use Rockbuzz\LaraTags\Traits\Taggable;

class Article extends Model
{
    use Taggable;
}
```

## Usage
```php
use Rockbuzz\LaraTags\Models\Tag;

$tag = Tag::findFromSlug('slug'); //instance or null
$tag = Tag::findFromSlug('slug', 'type'); //instance or null
```

```php
$article = new Article();
$article->tags(); //MorphToMany
$article->tags; //Collection
$article->tagsWithType('type'); //Collection
$article->hasTag('tag_name'); //boolean
$article->hasTag($tagInstance); //boolean
```
Scopes
```php
Article::withAnyTags($arrayTags);
Article::withAnyTags($arrayTags, 'type');
```
or
```php
Article::withAnyTags($arrayIdTags);
Article::withAnyTags($arrayIdTags, 'type');
```
or
```php
Article::withAnyTags($arrayNameTags);
Article::withAnyTags($arrayNameTags, 'type');
```

## License

The Lara Tags is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).