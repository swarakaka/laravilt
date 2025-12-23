---
title: Plugin Traits
description: Reusable plugin concerns
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
concept: traits
---

# Plugin Traits

Reusable concerns for plugin features.

## HasMigrations

```php
<?php

use Laravilt\Plugins\Concerns\HasMigrations;

class MyPlugin extends PluginProvider
{
    use HasMigrations;

    public function boot(Panel $panel): void
    {
        $this->loadMigrations();
    }
}
```

Methods: `migrations()`, `getMigrations()`, `loadMigrations()`

## HasTranslations

```php
<?php

use Laravilt\Plugins\Concerns\HasTranslations;

class MyPlugin extends PluginProvider
{
    use HasTranslations;

    public function boot(Panel $panel): void
    {
        $this->loadTranslations();
    }
}
```

Methods: `translations()`, `getTranslationNamespaces()`, `loadTranslations()`

## HasViews

```php
<?php

use Laravilt\Plugins\Concerns\HasViews;

class MyPlugin extends PluginProvider
{
    use HasViews;

    public function boot(Panel $panel): void
    {
        $this->loadViews();
        $this->publishViews();
    }
}
```

Methods: `viewNamespace()`, `getViewNamespace()`, `loadViews()`, `publishViews()`

## HasAssets

```php
<?php

use Laravilt\Plugins\Concerns\HasAssets;

class MyPlugin extends PluginProvider
{
    use HasAssets;

    public function boot(Panel $panel): void
    {
        $this->assets(['app.css', 'app.js']);
        $this->publishAssets();
    }
}
```

Methods: `assets()`, `assetsPath()`, `getAssets()`, `getAssetsPath()`, `publishAssets()`

## HasCommands

```php
<?php

use Laravilt\Plugins\Concerns\HasCommands;

class MyPlugin extends PluginProvider
{
    use HasCommands;

    protected array $pluginCommands = [
        Commands\InstallCommand::class,
    ];

    public function boot(Panel $panel): void
    {
        $this->registerPluginCommands();
    }
}
```

Methods: `pluginCommands()`, `getPluginCommands()`, `registerPluginCommands()`

## HasComponents

```php
<?php

use Laravilt\Plugins\Concerns\HasComponents;

class MyPlugin extends PluginProvider
{
    use HasComponents;

    public function boot(Panel $panel): void
    {
        $this->components([MyComponent::class]);
        $this->registerComponents();
    }
}
```

Methods: `components()`, `getComponents()`, `registerComponents()`

