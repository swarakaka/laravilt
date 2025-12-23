---
title: Boolean Filter
description: Yes/No toggle filter
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
---

# Boolean Filter

Toggle filter for boolean fields.

## Basic Usage

```php
<?php

use Laravilt\QueryBuilder\Filters\BooleanFilter;

BooleanFilter::make('is_active')
    ->label('Active Status');
```

## Custom Labels

```php
<?php

BooleanFilter::make('is_featured')
    ->label('Featured Products')
    ->trueLabel('Featured')
    ->falseLabel('Not Featured');
```

## With Default

```php
<?php

BooleanFilter::make('is_published')
    ->label('Published')
    ->trueLabel('Published')
    ->falseLabel('Draft')
    ->default(true);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create filter |
| `label(string)` | Display label |
| `trueLabel(string)` | Label for true (default: Yes) |
| `falseLabel(string)` | Label for false (default: No) |
| `default(mixed)` | Default value |
| `visible(bool)` | Visibility |

## Value Conversion

The filter uses `filter_var()` with `FILTER_VALIDATE_BOOLEAN`:

| Input | Result |
|-------|--------|
| `true` | `true` |
| `'true'` | `true` |
| `1` | `true` |
| `'1'` | `true` |
| `false` | `false` |
| `'false'` | `false` |
| `0` | `false` |

## SQL Generated

```sql
WHERE is_active = 1
-- or
WHERE is_active = 0
```

## Related

- [Text Filter](text) - Text search
- [Select Filter](select) - Dropdown
- [Date Filter](date) - Date ranges

