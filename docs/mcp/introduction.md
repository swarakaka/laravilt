---
title: MCP Server Integration
description: Model Context Protocol servers for AI agent integration
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# MCP Server Integration

Laravilt packages include built-in MCP (Model Context Protocol) servers for AI agent integration.

## What is MCP?

MCP enables AI agents like Claude to interact with your Laravilt application through standardized tools.

## Requirements

- Laravel MCP package: `laravel/mcp`
- PHP 8.2+
- Laravel 12.x

## Installation

Install the Laravel MCP package:

```bash
composer require laravel/mcp
```

Install package MCP servers:

```bash
php artisan laravilt:install-mcp
```

## Available Servers

| Package | Server | Tools |
|---------|--------|-------|
| `laravilt/forms` | laravilt-forms | generate-form, search-docs |
| `laravilt/tables` | laravilt-tables | generate-table, search-docs |
| `laravilt/panel` | laravilt-panel | list-features, get-resource-info, search-docs |
| `laravilt/auth` | laravilt-auth | list-auth-methods, get-event-info, search-docs |
| `laravilt/plugins` | laravilt-plugins | 7 tools for plugin management |

## Configuration

After installation, `.mcp.json` is updated:

```json
{
  "mcpServers": {
    "laravilt-forms": {
      "command": "php",
      "args": ["artisan", "mcp:start", "laravilt-forms"]
    }
  }
}
```

## Starting Servers

```bash
php artisan mcp:start laravilt-forms
php artisan mcp:start laravilt-tables
php artisan mcp:start laravilt-panel
```

## AI Agent Usage

AI agents can use these tools:

```
You: "Create a UserForm with validation"
Claude: [calls generate-form tool]

You: "Generate a posts table with actions"
Claude: [calls generate-table tool]
```

## Package Documentation

- [Forms MCP](forms) - Form generation tools
- [Tables MCP](tables) - Table generation tools
- [Panel MCP](panel) - Panel management tools
- [Auth MCP](auth) - Authentication tools
- [Plugins MCP](plugins) - Plugin management tools

## Security

MCP servers run with your Laravel application permissions. Ensure:
- Proper file permissions
- Secure MCP configuration
- Limited access to `.mcp.json`

## Related

- [Laravel MCP](https://laravel.com/docs/mcp) - Laravel MCP documentation
- [MCP Protocol](https://modelcontextprotocol.io) - MCP specification

