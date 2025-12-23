---
title: Query Tool
description: Search and filter records
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
component: QueryTool
---

# Query Tool

Search and filter database records.

## Basic Usage

```php
<?php

use Laravilt\AI\Tools\QueryTool;
use App\Models\Product;

$tool = QueryTool::make('search_products')
    ->description('Search and filter products')
    ->model(Product::class)
    ->searchableColumns(['name', 'description', 'sku'])
    ->limit(10);
```

## AI Calls

The AI can call this tool with:

```json
{
  "search": "laptop",
  "limit": 5,
  "orderBy": "price",
  "orderDirection": "asc"
}
```

## Searchable Columns

```php
<?php

use Laravilt\AI\Tools\QueryTool;

$tool = QueryTool::make('search_products')
    ->model(Product::class)
    ->searchableColumns(['name', 'sku', 'description'])
    ->limit(20);
```

## Auto Parameters

When you call `model()`, these parameters are auto-added:
- `search` - Search query string
- `limit` - Max results
- `orderBy` - Sort column
- `orderDirection` - asc/desc

## With Resource Agent

```php
<?php

use Laravilt\AI\ResourceAgent;
use App\Models\Product;

$agent = ResourceAgent::make('product_agent')
    ->model(Product::class)
    ->autoGenerateTools();

// Auto-creates QueryTool, CreateTool, UpdateTool, DeleteTool
```

## API Reference

| Method | Description |
|--------|-------------|
| `make()` | Create tool |
| `description()` | Tool description |
| `model()` | Set Eloquent model |
| `searchableColumns()` | Searchable columns |
| `limit()` | Default result limit |
