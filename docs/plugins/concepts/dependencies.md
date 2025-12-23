---
title: Dependencies
description: Plugin dependency management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: dependencies
---

# Dependencies

Manage plugin dependencies.

## Composer Dependencies

Define in composer.json:

```json
{
    "require": {
        "laravilt/comments": "^1.0",
        "laravilt/media": "^2.0"
    }
}
```

## Check Plugin Existence

```php
<?php

use Laravilt\Plugins\Facades\LaraviltPlugins;

// Check if plugin exists
if (LaraviltPlugins::has('comments-system')) {
    // Safe to use
}

// Get plugin
$plugin = LaraviltPlugins::get('comments-system');
```

## Conditional Features

```php
<?php

use Laravilt\Plugins\Facades\LaraviltPlugins;

class BlogPlugin extends PluginProvider
{
    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\PostResource::class,
        ]);

        // Optional: Add comments if available
        if (LaraviltPlugins::has('comments-system')) {
            $panel->resources([
                Resources\CommentResource::class,
            ]);
        }
    }
}
```

## Service Container

```php
<?php

use Laravilt\Plugins\Facades\LaraviltPlugins;

class BlogPlugin extends PluginProvider
{
    public function boot(Panel $panel): void
    {
        if (LaraviltPlugins::has('media-library')) {
            $mediaPlugin = LaraviltPlugins::get('media-library');
            // Use media plugin features
        }
    }
}
```

## Related

- [Plugin Classes](plugin-classes) - Base class
- [Registration](../manager/registration) - Register plugins

