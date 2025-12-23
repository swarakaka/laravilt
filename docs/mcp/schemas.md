---
title: Schemas MCP Server
description: MCP server for schema and layout management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Schemas MCP Server

MCP server for schema components and layout management.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Schemas\Mcp\LaraviltSchemasServer;

Mcp::local('laravilt-schemas', LaraviltSchemasServer::class);
```

## Available Tools

### list-components

List available schema components.

**Usage:**

```
list-components
```

**Output:**

- Section - Collapsible sections
- Grid - Multi-column layouts
- Tabs - Tabbed interfaces
- Wizard - Multi-step forms
- Split - Split layouts
- Fieldset - Grouped fields

### search-docs

Search schemas documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="wizard validation")
```

## AI Agent Examples

```
You: "What layout components are available?"
Claude: [calls list-components]

You: "How do I create a multi-step form?"
Claude: [calls search-docs with query="wizard"]

You: "How do I use grid layouts?"
Claude: [calls search-docs with query="grid columns"]
```

## Related

- [Schemas Introduction](../schemas/introduction) - Schemas overview
- [MCP Introduction](introduction) - MCP overview

