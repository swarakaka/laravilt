---
title: AI MCP Server
description: MCP server for AI integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# AI MCP Server

MCP server for AI provider management and integration.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\AI\Mcp\LaraviltAIServer;

Mcp::local('laravilt-ai', LaraviltAIServer::class);
```

## Available Tools

### list-providers

List available AI providers.

**Usage:**

```
list-providers
```

**Output:**

- OpenAI (GPT-4, GPT-3.5)
- Anthropic (Claude)
- Google (Gemini)
- Local models

### get-provider-info

Get information about a specific provider.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `provider` | string | Yes | Provider name |

**Usage:**

```
get-provider-info(provider="openai")
```

### search-docs

Search AI documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="function calling")
```

## AI Agent Examples

```
You: "What AI providers are supported?"
Claude: [calls list-providers]

You: "Tell me about OpenAI integration"
Claude: [calls get-provider-info with provider="openai"]

You: "How do I use function calling?"
Claude: [calls search-docs with query="function calling"]
```

## Related

- [AI Introduction](../ai/introduction) - AI overview
- [MCP Introduction](introduction) - MCP overview

