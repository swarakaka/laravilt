---
title: Plugins
description: Plugin architecture for Laravilt
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: plugins
---

# Plugins

Enterprise-grade plugin architecture for Laravilt.

## Getting Started

- [Installation](getting-started/installation) - Setup and requirements
- [Structure](getting-started/structure) - Plugin directory layout

## Core Concepts

- [Plugin Classes](concepts/plugin-classes) - Base class architecture
- [Traits](concepts/traits) - Available concerns
- [Dependencies](concepts/dependencies) - Package dependencies
- [Configuration](concepts/configuration) - Plugin config files

## Components

- [Introduction](components/introduction) - Component overview
- [Models](components/models) - Eloquent models
- [Resources](components/resources) - Panel resources
- [Commands](components/commands) - Artisan commands

## Plugin Manager

- [Introduction](manager/introduction) - Manager facade
- [Registration](manager/registration) - Register plugins

## Tutorials

- [Creating a Plugin](tutorials/creating-a-plugin) - Step-by-step guide

## Examples

- [Users Plugin](examples/users-plugin) - Complete RBAC example

## Quick Start

```bash
# Create new plugin
php artisan laravilt:plugin BlogManager

# Generate component
php artisan laravilt:make blog-manager model Post
```

## Plugin Example

```php
<?php

namespace MyCompany\BlogManager;

use Laravilt\Plugins\PluginProvider;
use Laravilt\Plugins\Contracts\Plugin;
use Filament\Panel;

class BlogManagerPlugin extends PluginProvider implements Plugin
{
    protected static string $id = 'blog-manager';
    protected static string $name = 'Blog Manager';

    public function register(Panel $panel): void
    {
        $panel->resources([
            Resources\PostResource::class,
        ]);
    }
}
```

