<?php

return [
    'models' => [
        'tag' => \Rockbuzz\LaraTags\Models\Tag::class
    ],
    'taggable_reference_uuid' => true,
    'route_key_name' => 'id'
];
