---
title: CRUD Tools
description: Create, Update, Delete tools
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
concept: crud-tools
---

# CRUD Tools

Tools for create, update, and delete operations.

## CreateTool

```php
<?php

use Laravilt\AI\Tools\CreateTool;
use App\Models\Product;

$tool = CreateTool::make('create_product')
    ->description('Create a new product')
    ->model(Product::class)
    ->fillable(['name', 'description', 'price', 'sku']);
```

When `model()` is called, fillable fields from model are auto-detected.

## UpdateTool

```php
<?php

use Laravilt\AI\Tools\UpdateTool;
use App\Models\Product;

$tool = UpdateTool::make('update_product')
    ->description('Update an existing product')
    ->model(Product::class)
    ->fillable(['name', 'description', 'price', 'stock']);
```

Auto-adds `id` parameter for record identification.

## DeleteTool

```php
<?php

use Laravilt\AI\Tools\DeleteTool;
use App\Models\Product;

// Soft delete (default)
$tool = DeleteTool::make('delete_product')
    ->description('Delete a product')
    ->model(Product::class)
    ->softDelete();

// Force delete
$tool = DeleteTool::make('force_delete')
    ->model(Product::class)
    ->forceDelete();
```

## Auto Generation

```php
<?php

use Laravilt\AI\ResourceAgent;
use App\Models\Product;

$agent = ResourceAgent::make('product_agent')
    ->model(Product::class)
    ->autoGenerateTools();

// Creates: query_products, create_Product, update_Product, delete_Product
```

## API Reference

| Method | Description |
|--------|-------------|
| `model()` | Set Eloquent model |
| `fillable()` | Allowed fields |
| `softDelete()` | Use soft delete |
| `forceDelete()` | Force delete |
