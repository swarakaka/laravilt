---
title: SelectFilter
description: Dropdown filter
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: SelectFilter
vue_component: TableSelectFilter
vue_package: "radix-vue (Select)"
---

# SelectFilter

Dropdown filter for table records.

## Basic Usage

```php
<?php

use Laravilt\Tables\Filters\SelectFilter;

SelectFilter::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ]);
```

## Multiple Selection

```php
<?php

use Laravilt\Tables\Filters\SelectFilter;
use App\Models\Category;

SelectFilter::make('categories')
    ->multiple()
    ->options(Category::pluck('name', 'id'));
```

## Relationship Filter

```php
<?php

use Laravilt\Tables\Filters\SelectFilter;

SelectFilter::make('category')
    ->relationship('category', 'name')
    ->searchable()
    ->preload();
```

## Custom Query

```php
<?php

use Laravilt\Tables\Filters\SelectFilter;

SelectFilter::make('status')
    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
    ->query(fn ($query, $data) =>
        $query->where('is_active', $data['value'] === 'active')
    );
```

## API Reference

| Method | Description |
|--------|-------------|
| `options()` | Set options |
| `multiple()` | Allow multiple |
| `searchable()` | Enable search |
| `relationship()` | From relation |
| `query()` | Custom query |
| `default()` | Default value |
