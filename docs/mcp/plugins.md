---
title: Plugins MCP Server
description: MCP server for plugin management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Plugins MCP Server

MCP server for plugin discovery, generation, and management.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Plugins\Mcp\LaraviltPluginsServer;

Mcp::local('laravilt-plugins', LaraviltPluginsServer::class);
```

## Available Tools

### list-plugins

List all installed Laravilt plugins.

**Usage:**

```
list-plugins
```

### plugin-info

Get detailed plugin information.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `plugin` | string | Yes | Plugin name (kebab-case) |

**Usage:**

```
plugin-info(plugin="blog-extensions")
```

### generate-plugin

Generate a new plugin with features.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `name` | string | Yes | Plugin name (StudlyCase) |
| `description` | string | No | Plugin description |
| `migrations` | boolean | No | Include migrations |
| `views` | boolean | No | Include views |
| `webRoutes` | boolean | No | Include web routes |
| `apiRoutes` | boolean | No | Include API routes |

**Usage:**

```
generate-plugin(
  name="BlogExtensions",
  description="Blog extensions",
  migrations=true,
  views=true
)
```

### generate-component

Generate a component within a plugin.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `plugin` | string | Yes | Plugin name (kebab-case) |
| `type` | string | Yes | Component type |
| `name` | string | Yes | Component name |

**Component Types:**

- `migration` - Database migration
- `model` - Eloquent model
- `controller` - HTTP controller
- `command` - Artisan command
- `job` - Queueable job
- `event` - Event class
- `listener` - Event listener
- `notification` - Notification
- `seeder` - Database seeder
- `factory` - Model factory
- `test` - Feature test

**Usage:**

```
generate-component(
  plugin="blog-extensions",
  type="model",
  name="Post"
)
```

### list-component-types

List available component types.

### plugin-structure

Get plugin directory structure.

### search-docs

Search plugin documentation.

## AI Agent Examples

```
You: "List all plugins"
Claude: [calls list-plugins]

You: "Create a BlogExtensions plugin with migrations"
Claude: [calls generate-plugin]

You: "Add a Post model to blog-extensions"
Claude: [calls generate-component]
```

## Related

- [Plugins Introduction](../plugins/introduction) - Plugins overview
- [MCP Introduction](introduction) - MCP overview

