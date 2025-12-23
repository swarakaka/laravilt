---
title: Plugin Manager
description: Manage installed plugins
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: manager
---

# Plugin Manager

Manage installed plugins programmatically.

## Using the Facade

```php
<?php

use Laravilt\Plugins\Facades\LaraviltPlugins;

// Get all plugins
$plugins = LaraviltPlugins::all();

// Get enabled plugins
$enabled = LaraviltPlugins::enabled();

// Get specific plugin
$plugin = LaraviltPlugins::get('blog-manager');

// Alternative: plugin() method
$plugin = LaraviltPlugins::plugin('blog-manager');

// Check if exists
if (LaraviltPlugins::has('blog-manager')) {
    // Plugin exists
}
```

## Register Plugin

```php
<?php

use Laravilt\Plugins\Facades\LaraviltPlugins;

LaraviltPlugins::register($plugin);
```

## Boot Plugins

```php
<?php

use Laravilt\Plugins\Facades\LaraviltPlugins;

// Boot all plugins
LaraviltPlugins::bootAll();

// Boot specific plugin
LaraviltPlugins::boot('blog-manager');
```

## Plugin Manifest

```php
<?php

$manifest = LaraviltPlugins::getManifest();

// Returns:
[
    [
        'id' => 'blog-manager',
        'name' => 'Blog Manager',
        'version' => '1.0.0',
        'description' => '...',
        'author' => 'MyCompany',
        'enabled' => true,
        'dependencies' => [],
    ],
]
```

## Related

- [Registration](registration) - Register plugins
- [Facade](facade) - Facade methods
