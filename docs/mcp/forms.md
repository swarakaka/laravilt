---
title: Forms MCP Server
description: MCP server for form generation
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: mcp
---

# Forms MCP Server

MCP server for generating forms with 30+ field types.

## Installation

```bash
php artisan laravilt:install-mcp
```

Registers in `routes/ai.php`:

```php
<?php

use Laravel\Mcp\Facades\Mcp;
use Laravilt\Forms\Mcp\LaraviltFormsServer;

Mcp::local('laravilt-forms', LaraviltFormsServer::class);
```

## Available Tools

### generate-form

Generate a new form class.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `name` | string | Yes | Form class name (StudlyCase) |
| `resource` | boolean | No | Generate resource form |
| `force` | boolean | No | Overwrite existing |

**Usage:**

```
generate-form(name="UserForm", resource=true)
```

**Output:**

```
✅ Form 'UserForm' created successfully!

📖 Location: app/Forms/UserForm.php

📦 Available field types: TextInput, Select, DatePicker,
   FileUpload, RichEditor, Repeater, and 24+ more
```

### search-docs

Search forms documentation.

**Arguments:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| `query` | string | Yes | Search query |

**Usage:**

```
search-docs(query="file upload validation")
```

## AI Agent Examples

```
You: "Create a contact form"
Claude: [calls generate-form with name="ContactForm"]

You: "Create a resource form for managing posts"
Claude: [calls generate-form with name="PostForm", resource=true]

You: "How do I add file upload validation?"
Claude: [calls search-docs with query="file upload validation"]
```

## Related

- [Forms Introduction](../forms/introduction) - Forms overview
- [MCP Introduction](introduction) - MCP overview

