---
title: AI Columns
description: Column definitions for AI agents
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: ai
component: AIColumn
---

# AI Columns

Define columns for AI agent understanding.

## Basic Column

```php
<?php

use Laravilt\AI\AIColumn;

AIColumn::make('name')
    ->label('Product Name')
    ->searchable()
    ->sortable();
```

## Column Types

```php
<?php

use Laravilt\AI\AIColumn;

// String (default)
AIColumn::make('name')->type('string');

// Numeric
AIColumn::make('price')->type('decimal');
AIColumn::make('quantity')->type('integer');

// Boolean
AIColumn::make('is_active')->type('boolean');

// Date/Time
AIColumn::make('created_at')->type('datetime');
AIColumn::make('published_at')->type('date');
```

## Searchable & Filterable

```php
<?php

use Laravilt\AI\AIColumn;

AIColumn::make('name')
    ->searchable()
    ->filterable()
    ->sortable();

AIColumn::make('status')
    ->filterable()
    ->options(['active', 'pending', 'inactive']);
```

## Relationships

```php
<?php

use Laravilt\AI\AIColumn;

AIColumn::make('category_id')
    ->type('integer')
    ->filterable()
    ->relationship('category');

AIColumn::make('category')
    ->relationship('category', 'name')
    ->filterable();
```

## Complete Example

```php
<?php

use Laravilt\AI\AIColumn;

$columns = [
    AIColumn::make('id')->type('integer')->sortable(),
    AIColumn::make('name')->label('Product Name')->searchable()->sortable(),
    AIColumn::make('sku')->searchable(),
    AIColumn::make('price')->type('decimal')->filterable()->sortable(),
    AIColumn::make('stock')->type('integer')->filterable(),
    AIColumn::make('is_active')->type('boolean')->filterable(),
    AIColumn::make('category_id')->relationship('category')->filterable(),
    AIColumn::make('created_at')->type('datetime')->sortable(),
];
```

## API Reference

| Method | Description |
|--------|-------------|
| `type()` | Data type |
| `label()` | Display label |
| `searchable()` | Enable search |
| `filterable()` | Enable filter |
| `sortable()` | Enable sort |
| `relationship()` | Define relation |
| `options()` | Allowed values |
