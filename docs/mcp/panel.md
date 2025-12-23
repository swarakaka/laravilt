---
title: Panel MCP Server
description: MCP server for admin panel management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Panel MCP Server

MCP server for admin panel management, resources, and pages.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Panel\Mcp\LaraviltPanelServer;

Mcp::local('laravilt-panel', LaraviltPanelServer::class);
```

## Available Tools

### list-panel-features

List available panel features and configuration options.

**Usage:**

```
list-panel-features
```

### get-resource-info

Get information about resources, pages, and navigation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `resource` | string | Yes | Resource name |

**Usage:**

```
get-resource-info(resource="users")
```

### search-docs

Search panel documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="multi-tenancy")
```

## Artisan Commands

The server provides information about generator commands:

```bash
# Create a new panel
php artisan laravilt:panel {id} --path={path}

# Create a new page
php artisan laravilt:page {panel} {name}

# Create a new resource
php artisan laravilt:resource {panel} --table={table}
```

## AI Agent Examples

```
You: "What features does the panel support?"
Claude: [calls list-panel-features]

You: "Tell me about the users resource"
Claude: [calls get-resource-info with resource="users"]

You: "How do I set up multi-tenancy?"
Claude: [calls search-docs with query="multi-tenancy"]
```

## Related

- [Panel Introduction](../panel/introduction) - Panel overview
- [MCP Introduction](introduction) - MCP overview

