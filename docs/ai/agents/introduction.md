---
title: AI Agents
description: Resource-aware AI assistants
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: agents
---

# AI Agents

AI assistants with resource capabilities and tool calling.

## Overview

| Topic | Description |
|-------|-------------|
| [Resource Agents](resource-agents) | Per-resource AI |
| [AI Columns](ai-columns) | Column definitions |
| [Configuration](configuration) | Agent settings |

## Basic Agent

```php
<?php

use Laravilt\AI\Agent;

$agent = Agent::make('product_assistant')
    ->description('AI assistant for product management')
    ->instructions('You help users manage products.')
    ->tools([
        // Add tools here
    ]);
```

## Resource Agent

```php
<?php

use Laravilt\AI\ResourceAgent;
use App\Models\Product;

$agent = ResourceAgent::make('product_agent')
    ->model(Product::class)
    ->autoGenerateTools()
    ->description('Manage products via AI');
```

## AI Manager

```php
<?php

use Laravilt\AI\AIManager;

$ai = app(AIManager::class);

$response = $ai->provider('openai')->chat([
    ['role' => 'user', 'content' => 'Hello!'],
]);

// Check configuration
if ($ai->isConfigured()) {
    $providers = $ai->getProviders();
}
```

## Related

- [Resource Agents](resource-agents) - CRUD capabilities
- [AI Columns](ai-columns) - Column definitions
