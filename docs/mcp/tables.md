---
title: Tables MCP Server
description: MCP server for table generation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Tables MCP Server

MCP server for generating data tables with columns, filters, and actions.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Tables\Mcp\LaraviltTablesServer;

Mcp::local('laravilt-tables', LaraviltTablesServer::class);
```

## Available Tools

### generate-table

Generate a new table class.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `name` | string | Yes | Table class name (StudlyCase) |
| `actions` | boolean | No | Include row and bulk actions |
| `force` | boolean | No | Overwrite existing |

**Usage:**

```
generate-table(name="UserTable", actions=true)
```

**Output:**

```
✅ Table 'UserTable' created successfully!

📖 Location: app/Tables/UserTable.php

📦 Available column types: TextColumn, ImageColumn, BadgeColumn,
   IconColumn, SelectColumn, ToggleColumn
```

### search-docs

Search tables documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="bulk actions")
```

## AI Agent Examples

```
You: "Create a users table with actions"
Claude: [calls generate-table with name="UserTable", actions=true]

You: "Generate a posts table for the admin panel"
Claude: [calls generate-table with name="PostTable", actions=true]

You: "How do I add filters to a table?"
Claude: [calls search-docs with query="filters"]
```

## Related

- [Tables Introduction](../tables/introduction) - Tables overview
- [MCP Introduction](introduction) - MCP overview

