---
title: Query Builder
description: Filtering and sorting for data queries
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
vue_package: "@laravilt/query-builder"
---

# Query Builder

Fluent filtering, sorting, and pagination for queries.

## Installation

```bash
composer require laravilt/query-builder
```

## Documentation

- [Filters](filters/introduction) - All filter types
- [Text Filter](filters/text) - Text search
- [Select Filter](filters/select) - Dropdown options
- [Boolean Filter](filters/boolean) - Yes/No toggle
- [Date Filter](filters/date) - Date ranges
- [Sorting](sorting) - Column sorting

## Quick Example

```php
<?php

use Laravilt\QueryBuilder\QueryBuilder;
use Laravilt\QueryBuilder\Filters\TextFilter;
use Laravilt\QueryBuilder\Filters\SelectFilter;
use Laravilt\QueryBuilder\Sort;

$builder = (new QueryBuilder())
    ->filters([
        TextFilter::make('name')->contains(),
        SelectFilter::make('status')
            ->options(['active' => 'Active', 'inactive' => 'Inactive']),
    ])
    ->sorts([
        Sort::make('name'),
        Sort::make('created_at')->defaultDirection('desc'),
    ])
    ->applyFilters($request->all())
    ->sortBy('created_at', 'desc')
    ->perPage(15);

$query = Product::query();
$builder->apply($query);
$products = $query->paginate(15);
```

## Methods

| Method | Description |
|--------|-------------|
| `filters(array)` | Set filter array |
| `addFilter(Filter)` | Add single filter |
| `sorts(array)` | Set sort array |
| `addSort(Sort)` | Add single sort |
| `applyFilters(array)` | Apply filter values |
| `search(?string)` | Global search |
| `sortBy(col, dir)` | Apply sorting |
| `perPage(int)` | Items per page |
| `paginated(bool)` | Enable pagination |
| `apply(Builder)` | Apply to query |

## Related

- [Tables](../tables/introduction) - Table integration
- [Filters](filters/introduction) - Filter types

