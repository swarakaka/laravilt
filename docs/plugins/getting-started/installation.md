---
title: Installation
description: Create and install plugins
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: installation
---

# Installation

Create and install Laravilt plugins.

## Create Plugin

```bash
# Interactive mode
php artisan laravilt:plugin

# Quick create
php artisan laravilt:plugin BlogManager

# With vendor
php artisan laravilt:plugin BlogManager --vendor=mycompany
```

## Feature Selection

Select features during creation:

- Laravilt plugin (Filament integration)
- Database migrations
- Blade views
- Web routes
- API routes
- CSS assets (Tailwind v4)
- JavaScript assets (Vue.js + Vite)
- Language files
- GitHub workflows
- PHPStan configuration

## Post-Generation

After generation:
- Initialize Git repository
- Run composer install
- Run tests

## Install Existing Plugin

```bash
# Install via Composer
composer require vendor/plugin-name

# Run migrations
php artisan migrate

# Run install command (if available)
php artisan plugin-name:install
```

## Register in Panel

```php
<?php

use Vendor\PluginName\PluginNamePlugin;

$panel->plugins([
    PluginNamePlugin::make(),
]);
```

## Related

- [Structure](structure) - Plugin structure
- [Creating Plugin](../tutorials/creating-a-plugin) - Full guide
