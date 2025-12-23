---
title: Table Filters
description: Filter types for data tables
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: filters
---

# Table Filters

Filter types for querying table data.

## Available Filters

| Filter | Description |
|--------|-------------|
| [SelectFilter](select-filter) | Dropdown selection |
| [TernaryFilter](ternary-filter) | True/False/All |
| [TrashedFilter](trashed-filter) | Soft deletes |

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Tables\Filters\SelectFilter;
use Laravilt\Tables\Filters\TernaryFilter;

$table->filters([
    SelectFilter::make('status')
        ->options([
            'draft' => 'Draft',
            'published' => 'Published',
        ]),

    TernaryFilter::make('is_featured')
        ->label('Featured'),
]);
```

## Filter Indicators

```php
<?php

use Laravilt\Tables\Filters\SelectFilter;

SelectFilter::make('status')
    ->indicateUsing(fn ($value) => "Status: {$value}");
```

## Related

- [Select Filter](select-filter) - Dropdown filter
- [Ternary Filter](ternary-filter) - Boolean filter
- [Trashed Filter](trashed-filter) - Soft delete filter
