---
title: Searching
description: Global search functionality
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
vue_component: TableSearch
---

# Searching

Global search across table columns.

## Enable Search

```php
<?php

use Laravilt\Tables\Table;

$table->searchable();
```

## Searchable Columns

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')->searchable();
TextColumn::make('email')->searchable();
TextColumn::make('phone')->searchable();
```

## Search Placeholder

```php
<?php

use Laravilt\Tables\Table;

$table
    ->searchable()
    ->searchPlaceholder('Search users...');
```

## Debounced Search

```php
<?php

use Laravilt\Tables\Table;

$table
    ->searchable()
    ->searchDebounce(500); // 500ms
```

## Custom Search Query

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('full_name')
    ->searchable(query: function ($query, $search) {
        $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
    });
```

## API Reference

| Method | Description |
|--------|-------------|
| `searchable()` | Enable global search |
| `searchPlaceholder()` | Placeholder text |
| `searchDebounce()` | Debounce ms |
