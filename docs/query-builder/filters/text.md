---
title: Text Filter
description: Text-based filtering
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
---

# Text Filter

Text-based filtering with operators.

## Basic Usage

```php
<?php

use Laravilt\QueryBuilder\Filters\TextFilter;

TextFilter::make('name')
    ->label('Product Name')
    ->contains()
    ->placeholder('Search products...');
```

## Operators

```php
<?php

// Contains (LIKE %value%)
TextFilter::make('name')->contains();

// Exact match (= value)
TextFilter::make('sku')->exact();

// Starts with (LIKE value%)
TextFilter::make('email')->startsWith();

// Ends with (LIKE %value)
TextFilter::make('domain')->endsWith();
```

## Case Sensitivity

```php
<?php

TextFilter::make('name')
    ->contains()
    ->caseSensitive();
```

## Custom Operator

```php
<?php

TextFilter::make('name')
    ->operator('like');  // '=', 'like', 'starts_with', 'ends_with'
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create filter |
| `contains()` | Substring match |
| `exact()` | Exact match |
| `startsWith()` | Prefix match |
| `endsWith()` | Suffix match |
| `caseSensitive(bool)` | Case sensitive |
| `operator(string)` | Custom operator |

## SQL Generated

| Method | SQL |
|--------|-----|
| `contains()` | `WHERE col LIKE '%val%'` |
| `exact()` | `WHERE col = 'val'` |
| `startsWith()` | `WHERE col LIKE 'val%'` |
| `endsWith()` | `WHERE col LIKE '%val'` |

## Related

- [Select Filter](select) - Dropdown
- [Boolean Filter](boolean) - Toggle

