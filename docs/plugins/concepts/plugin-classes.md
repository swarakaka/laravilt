---
title: Plugin Classes
description: Plugin base classes
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: plugin-classes
---

# Plugin Classes

Base class for plugin development.

## PluginProvider

For panel integration:

```php
<?php

namespace MyCompany\BlogManager;

use Laravilt\Plugins\PluginProvider;
use Laravilt\Plugins\Contracts\Plugin;
use Laravilt\Panel\Panel;

class BlogManagerPlugin extends PluginProvider implements Plugin
{
    protected static string $id = 'blog-manager';
    protected static string $name = 'Blog Manager';
    protected static string $version = '1.0.0';
    protected static string $description = 'Blog management';
    protected static string $author = 'MyCompany';

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\PostResource::class,
        ])->pages([
            Pages\Dashboard::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        // Boot logic
    }
}
```

## Required Properties

```php
<?php

protected static string $id = 'unique-plugin-id';
```

## Optional Properties

```php
<?php

protected static string $name = 'Display Name';
protected static string $version = '1.0.0';
protected static string $description = 'Description';
protected static string $author = 'Author Name';
protected bool $enabled = true;
```

## Instance Methods

| Method | Return | Description |
|--------|--------|-------------|
| `make()` | `static` | Create instance |
| `getId()` | `string` | Get plugin ID |
| `getName()` | `string` | Get plugin name |
| `getVersion()` | `string` | Get version |
| `getDescription()` | `string` | Get description |
| `getAuthor()` | `string` | Get author |
| `isEnabled()` | `bool` | Check if enabled |
| `enable()` | `static` | Enable plugin |
| `disable()` | `static` | Disable plugin |

## Related

- [Traits](traits) - Plugin concerns
- [Configuration](configuration) - Config files

