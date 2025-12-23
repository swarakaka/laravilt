---
title: Notifications MCP Server
description: MCP server for notification management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Notifications MCP Server

MCP server for notification creation and management.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Notifications\Mcp\LaraviltNotificationsServer;

Mcp::local('laravilt-notifications', LaraviltNotificationsServer::class);
```

## Available Tools

### search-docs

Search notifications documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="toast notifications")
```

### list-notification-types

List available notification types.

**Usage:**

```
list-notification-types
```

**Output:**

- Success notifications
- Error notifications
- Warning notifications
- Info notifications
- Database notifications
- Toast notifications

## AI Agent Examples

```
You: "What notification types are available?"
Claude: [calls list-notification-types]

You: "How do I create toast notifications?"
Claude: [calls search-docs with query="toast notifications"]

You: "How do I send database notifications?"
Claude: [calls search-docs with query="database notifications"]
```

## Related

- [Notifications Introduction](../notifications/introduction) - Notifications overview
- [MCP Introduction](introduction) - MCP overview

