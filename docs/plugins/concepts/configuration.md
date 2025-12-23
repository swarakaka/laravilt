---
title: Configuration
description: Plugin configuration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: configuration
---

# Configuration

Configure plugin behavior.

## Config File

```php
<?php

// config/laravilt-blog-manager.php
return [
    'enabled' => env('LARAVILT_BLOG_MANAGER_ENABLED', true),

    'posts_per_page' => env('BLOG_POSTS_PER_PAGE', 10),

    'allow_comments' => env('BLOG_ALLOW_COMMENTS', true),

    'moderation' => [
        'enabled' => true,
        'auto_approve' => false,
    ],
];
```

## Accessing Config

```php
<?php

config('laravilt-blog-manager.posts_per_page');
```

## Fluent Configuration

```php
<?php

class BlogPlugin extends PluginProvider
{
    protected int $postsPerPage = 10;
    protected bool $allowComments = true;

    public function postsPerPage(int $count): static
    {
        $this->postsPerPage = $count;
        return $this;
    }

    public function allowComments(bool $enabled = true): static
    {
        $this->allowComments = $enabled;
        return $this;
    }
}
```

## Usage

```php
<?php

use MyCompany\BlogManager\BlogPlugin;

$panel->plugins([
    BlogPlugin::make()
        ->postsPerPage(15)
        ->allowComments(false),
]);
```

## Publishing Config

```php
<?php

$this->publishes([
    __DIR__.'/../config/blog.php' => config_path('blog.php'),
], 'blog-config');
```
