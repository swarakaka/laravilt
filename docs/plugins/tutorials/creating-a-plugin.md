---
title: Creating a Plugin
description: Step-by-step plugin tutorial
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
type: tutorial
---

# Creating a Plugin

Complete step-by-step guide to building a plugin.

## Step 1: Generate Scaffold

```bash
php artisan laravilt:plugin UserManager --vendor=mycompany
```

Select features:
- Laravilt plugin (Filament integration)
- Database migrations
- Language files

## Step 2: Define Plugin Class

```php
<?php

namespace MyCompany\UserManager;

use Laravilt\Plugins\PluginProvider;
use Laravilt\Plugins\Contracts\Plugin;
use Filament\Panel;

class UserManagerPlugin extends PluginProvider implements Plugin
{
    use Concerns\HasMigrations;
    use Concerns\HasTranslations;

    protected static string $id = 'user-manager';
    protected static string $name = 'User Manager';
    protected static string $version = '1.0.0';

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\UserResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        $this->loadMigrations();
        $this->loadTranslations();
    }
}
```

## Step 3: Generate Components

```bash
php artisan laravilt:make user-manager model User
php artisan laravilt:make user-manager migration User
php artisan laravilt:make user-manager resource User
```

## Step 4: Add Configuration

```php
<?php

class UserManagerPlugin extends PluginProvider
{
    protected bool $hasAvatar = false;

    public function avatar(bool $enabled = true): static
    {
        $this->hasAvatar = $enabled;
        return $this;
    }
}
```

## Step 5: Register Plugin

```php
<?php

$panel->plugins([
    UserManagerPlugin::make()
        ->avatar(),
]);
```

## Related

- [Users Plugin](../examples/users-plugin) - Complete example
- [Plugin Classes](../concepts/plugin-classes) - Architecture

