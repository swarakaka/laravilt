---
title: Sorting
description: Column sorting functionality
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
vue_component: TableSort
---

# Sorting

Column sorting for table data.

## Sortable Columns

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')->sortable();
TextColumn::make('created_at')->sortable();
TextColumn::make('price')->sortable();
```

## Default Sort

```php
<?php

use Laravilt\Tables\Table;

$table->defaultSort('created_at', 'desc');
```

## Custom Sort Query

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('author_name')
    ->sortable(query: function ($query, $direction) {
        $query->orderBy('author.name', $direction);
    });
```

## Multi-Column Sort

```php
<?php

use Laravilt\Tables\Table;

$table->defaultSort([
    'status' => 'asc',
    'created_at' => 'desc',
]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `sortable()` | Enable column sort |
| `defaultSort()` | Default sort column |
