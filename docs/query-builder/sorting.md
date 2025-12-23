---
title: Sorting
description: Column sorting for queries
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
---

# Sorting

Configure sortable columns.

## Basic Usage

```php
<?php

use Laravilt\QueryBuilder\Sort;

$builder->sorts([
    Sort::make('name'),
    Sort::make('created_at')->defaultDirection('desc'),
    Sort::make('price')->label('Price'),
]);
```

## With Custom Column

```php
<?php

Sort::make('price')
    ->label('Price')
    ->column('price_cents');  // Different DB column
```

## Apply Sorting

```php
<?php

$builder->sortBy('created_at', 'desc');

// From request
$builder->sortBy(
    $request->get('sort'),
    $request->get('direction', 'asc')
);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(name, ?column)` | Create sort |
| `label(string)` | Display label |
| `column(string)` | Database column |
| `defaultDirection(string)` | asc or desc |
| `visible(bool)` | Visibility |
| `getName()` | Get name |
| `getColumn()` | Get column |
| `getLabel()` | Get label |

## Auto Label

Labels are auto-generated from names:

| Name | Generated Label |
|------|-----------------|
| `created_at` | Created At |
| `product_name` | Product Name |
| `user_email` | User Email |

## Complete Example

```php
<?php

use Laravilt\QueryBuilder\QueryBuilder;
use Laravilt\QueryBuilder\Sort;

$builder = (new QueryBuilder())
    ->sorts([
        Sort::make('name')->label('Name'),
        Sort::make('email')->label('Email'),
        Sort::make('created_at')
            ->label('Registration Date')
            ->defaultDirection('desc'),
    ])
    ->sortBy($request->get('sort', 'created_at'), 'desc');
```

## Related

- [Filters](filters/introduction) - Query filters
- [Tables](../tables/introduction) - Table integration

