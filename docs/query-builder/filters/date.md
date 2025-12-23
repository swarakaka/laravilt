---
title: Date Filter
description: Date-based filtering
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: query-builder
---

# Date Filter

Date-based filtering with ranges.

## Basic Usage

```php
<?php

use Laravilt\QueryBuilder\Filters\DateFilter;

DateFilter::make('created_at')
    ->label('Created Date');
```

## Operators

```php
<?php

// Equal to date
DateFilter::make('published_at');

// Before date
DateFilter::make('expires_at')
    ->before();

// After date
DateFilter::make('start_date')
    ->after();

// Between dates
DateFilter::make('created_at')
    ->between();
```

## Date Constraints

```php
<?php

DateFilter::make('published_at')
    ->label('Published Date')
    ->minDate('2024-01-01')
    ->maxDate('2024-12-31');
```

## With Time

```php
<?php

DateFilter::make('scheduled_at')
    ->label('Scheduled')
    ->withTime();
```

## Complete Example

```php
<?php

DateFilter::make('created_at')
    ->label('Created Between')
    ->between()
    ->minDate('2024-01-01')
    ->maxDate('2024-12-31')
    ->withTime();
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create filter |
| `label(string)` | Display label |
| `operator(string)` | Custom operator |
| `before()` | Less than |
| `after()` | Greater than |
| `between()` | Date range |
| `minDate(string)` | Minimum date |
| `maxDate(string)` | Maximum date |
| `withTime(bool)` | Include time |

## SQL Generated

| Operator | SQL |
|----------|-----|
| Default | `WHERE col = 'date'` |
| `before()` | `WHERE col < 'date'` |
| `after()` | `WHERE col > 'date'` |
| `between()` | `WHERE col BETWEEN 'd1' AND 'd2'` |

## Related

- [Boolean Filter](boolean) - Toggle
- [Text Filter](text) - Text search

