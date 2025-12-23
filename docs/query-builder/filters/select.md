---
title: Select Filter
description: Dropdown selection filter
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
---

# Select Filter

Dropdown-based filtering.

## Basic Usage

```php
<?php

use Laravilt\QueryBuilder\Filters\SelectFilter;

SelectFilter::make('status')
    ->label('Status')
    ->options([
        'active' => 'Active',
        'inactive' => 'Inactive',
    ])
    ->default('active');
```

## Multiple Selection

```php
<?php

SelectFilter::make('categories')
    ->label('Categories')
    ->options([
        'electronics' => 'Electronics',
        'furniture' => 'Furniture',
        'fitness' => 'Fitness',
    ])
    ->multiple()
    ->searchable();
```

## Dynamic Options

```php
<?php

use App\Models\Category;

SelectFilter::make('category_id')
    ->label('Category')
    ->options(Category::pluck('name', 'id')->toArray());
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create filter |
| `options(array)` | Key-value options |
| `multiple(bool)` | Allow multiple |
| `searchable(bool)` | Enable search |
| `default(mixed)` | Default value |
| `placeholder(string)` | Placeholder text |

## SQL Generated

| Mode | SQL |
|------|-----|
| Single | `WHERE col = 'value'` |
| Multiple | `WHERE col IN ('a', 'b')` |

## Complete Example

```php
<?php

SelectFilter::make('role')
    ->label('User Role')
    ->options([
        'admin' => 'Administrator',
        'editor' => 'Editor',
        'user' => 'User',
    ])
    ->multiple()
    ->searchable()
    ->placeholder('Select roles...');
```

## Related

- [Text Filter](text) - Text search
- [Boolean Filter](boolean) - Toggle

