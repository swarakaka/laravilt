---
title: Grouping
description: Row grouping by column
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
vue_component: TableGroup
---

# Grouping

Group table rows by column values.

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;

$table
    ->groupBy('category')
    ->groupLabel(fn ($value) => "Category: {$value}");
```

## Relationship Grouping

```php
<?php

use Laravilt\Tables\Table;

$table
    ->groupBy('category.name')
    ->collapsible();
```

## Group Stats

```php
<?php

use Laravilt\Tables\Table;

$table
    ->groupBy('status')
    ->groupStats(function ($records) {
        return "Total: {$records->count()}";
    });
```

## Collapsible Groups

```php
<?php

use Laravilt\Tables\Table;

$table
    ->groupBy('department')
    ->collapsible()
    ->collapsedByDefault();
```

## Multiple Grouping

```php
<?php

use Laravilt\Tables\Table;

$table
    ->groupBy(['category', 'status']);
```

## API Reference

| Method | Description |
|--------|-------------|
| `groupBy()` | Group column(s) |
| `groupLabel()` | Custom label |
| `groupStats()` | Group statistics |
| `collapsible()` | Allow collapse |
| `collapsedByDefault()` | Start collapsed |
