---
title: Auth MCP Server
description: MCP server for authentication management
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Auth MCP Server

MCP server for authentication methods, events, and configuration.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Auth\Mcp\LaraviltAuthServer;

Mcp::local('laravilt-auth', LaraviltAuthServer::class);
```

## Available Tools

### list-auth-methods

List all available authentication methods.

**Usage:**

```
list-auth-methods
```

**Output:**

Lists all 8 authentication methods:
- Standard login/register
- Two-factor authentication (2FA)
- OTP (One-Time Password)
- Social authentication
- Passkeys (WebAuthn)
- Magic links
- API tokens
- SSO

### get-event-info

Get information about authentication events.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `event` | string | Yes | Event name |

**Usage:**

```
get-event-info(event="Login")
```

### search-docs

Search authentication documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="passkeys setup")
```

## AI Agent Examples

```
You: "What auth methods are available?"
Claude: [calls list-auth-methods]

You: "Tell me about the Login event"
Claude: [calls get-event-info with event="Login"]

You: "How do I set up passkeys?"
Claude: [calls search-docs with query="passkeys setup"]
```

## Related

- [Auth Introduction](../auth/introduction) - Auth overview
- [MCP Introduction](introduction) - MCP overview

