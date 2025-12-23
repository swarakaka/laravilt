---
title: Filters
description: Query filter types
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
---

# Filters

Available filter types for query building.

## Filter Types

- [Text Filter](text) - Text search with operators
- [Select Filter](select) - Dropdown selection
- [Boolean Filter](boolean) - Yes/No toggle
- [Date Filter](date) - Date ranges

## Base Filter Methods

All filters share these methods:

```php
<?php

use Laravilt\QueryBuilder\Filters\Filter;

Filter::make('name')
    ->label('Display Label')
    ->column('db_column')
    ->default('value')
    ->visible(true)
    ->placeholder('Enter value...')
    ->query(fn ($query, $value) => $query->where('name', $value));
```

| Method | Description |
|--------|-------------|
| `make(string)` | Create filter |
| `label(string)` | Display label |
| `column(string)` | Database column |
| `default(mixed)` | Default value |
| `visible(bool)` | Visibility |
| `placeholder(string)` | Placeholder text |
| `query(Closure)` | Custom query logic |
| `getName()` | Get filter name |
| `getLabel()` | Get label |
| `getColumn()` | Get column |

## Custom Query

```php
<?php

use Laravilt\QueryBuilder\Filters\TextFilter;

TextFilter::make('search')
    ->query(function ($query, $value) {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    });
```

## Conditional Visibility

```php
<?php

TextFilter::make('admin_notes')
    ->visible(auth()->user()->isAdmin());
```

## Related

- [Text Filter](text) - Text operators
- [Select Filter](select) - Dropdowns

