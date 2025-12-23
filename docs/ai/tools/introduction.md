---
title: AI Tools
description: Function calling for AI agents
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: tools
---

# AI Tools

Tools give AI agents ability to perform actions.

## Overview

| Topic | Description |
|-------|-------------|
| [Query Tool](query-tool) | Search records |
| [CRUD Tools](crud-tools) | Create, Update, Delete |
| [Custom Tools](custom-tools) | Build your own |

## Built-in Tools

| Tool | Description |
|------|-------------|
| QueryTool | Search and filter records |
| CreateTool | Create new records |
| UpdateTool | Update existing records |
| DeleteTool | Delete records |

## Basic Usage

```php
<?php

use Laravilt\AI\AIManager;

$response = $ai->provider()->chatWithTools(
    messages: [
        ['role' => 'user', 'content' => 'Find products under $50'],
    ],
    tools: $agent->getTools()
);

if ($response['tool_calls']) {
    foreach ($response['tool_calls'] as $call) {
        $result = executeToolCall($call);
    }
}
```

## Automatic Tool Generation

Resource agents auto-generate tools:

```php
<?php

use Laravilt\AI\ResourceAgent;
use App\Models\Product;

$agent = ResourceAgent::make('product_agent')
    ->model(Product::class)
    ->autoGenerateTools();

// Creates: QueryTool, CreateTool, UpdateTool, DeleteTool
```

## Related

- [Query Tool](query-tool) - Search records
- [CRUD Tools](crud-tools) - Data operations
- [Custom Tools](custom-tools) - Build custom
