---
title: Pagination
description: Pagination and infinite scroll
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: display
vue_component: TablePagination
---

# Pagination

Pagination and infinite scroll options.

## Basic Pagination

```php
<?php

use Laravilt\Tables\Table;

$table
    ->paginated()
    ->perPage(25)
    ->paginationPageOptions([10, 25, 50, 100]);
```

## Infinite Scroll

```php
<?php

use Laravilt\Tables\Table;

$table
    ->infiniteScroll()
    ->perPage(20);
```

## Simple Pagination

```php
<?php

use Laravilt\Tables\Table;

$table
    ->simplePagination()
    ->perPage(15);
```

## Without Pagination

```php
<?php

use Laravilt\Tables\Table;

$table->paginated(false);
```

## Default Per Page

```php
<?php

use Laravilt\Tables\Table;

$table
    ->defaultPerPage(50)
    ->paginationPageOptions([25, 50, 100, 200]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `paginated()` | Enable pagination |
| `perPage()` | Items per page |
| `paginationPageOptions()` | Per page options |
| `infiniteScroll()` | Enable infinite scroll |
| `simplePagination()` | Simple prev/next |
| `defaultPerPage()` | Default per page |
