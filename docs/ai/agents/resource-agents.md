---
title: Resource Agents
description: Per-resource AI capabilities
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
component: AIAgent
---

# Resource Agents

Configure AI capabilities for each resource.

## Basic Configuration

```php
<?php

namespace App\Laravilt\Admin\Resources\Product;

use Laravilt\Panel\Resources\Resource;
use Laravilt\AI\AIAgent;
use Laravilt\AI\AIColumn;

class ProductResource extends Resource
{
    public static function ai(AIAgent $agent): AIAgent
    {
        return $agent
            ->name('product_assistant')
            ->description('AI assistant for managing products')
            ->systemPrompt('You are a helpful product assistant.')
            ->searchable(['name', 'description', 'sku'])
            ->columns([
                AIColumn::make('name')->searchable(),
                AIColumn::make('price')->type('decimal')->sortable(),
                AIColumn::make('is_active')->type('boolean')->filterable(),
            ])
            ->canCreate(true)
            ->canUpdate(true)
            ->canDelete(false)
            ->canQuery(true);
    }
}
```

## CRUD Permissions

```php
<?php

use Laravilt\AI\AIAgent;

$agent
    ->canCreate(auth()->user()->can('create', Product::class))
    ->canUpdate(auth()->user()->can('update', Product::class))
    ->canDelete(false)
    ->canQuery(true);
```

## Custom Provider

```php
<?php

use Laravilt\AI\AIAgent;
use Laravilt\AI\Enums\OpenAIModel;

$agent
    ->provider('openai')
    ->aiModel(OpenAIModel::GPT_4O);
```

## Custom Tools

```php
<?php

use Laravilt\AI\AIAgent;
use Laravilt\AI\Tools\Tool;

$agent->tools([
    Tool::make('calculate_discount')
        ->description('Calculate discount price')
        ->addParameter('price', 'number', 'Original price', true)
        ->addParameter('percent', 'number', 'Discount %', true)
        ->handler(fn ($args) => $args['price'] * (1 - $args['percent'] / 100)),
]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `name()` | Agent name |
| `description()` | Agent description |
| `systemPrompt()` | System instructions |
| `searchable()` | Searchable columns |
| `columns()` | AI column definitions |
| `tools()` | Custom tools |
| `canCreate()` | Allow create |
| `canUpdate()` | Allow update |
| `canDelete()` | Allow delete |
| `canQuery()` | Allow query |
| `provider()` | AI provider |
| `aiModel()` | AI model |
