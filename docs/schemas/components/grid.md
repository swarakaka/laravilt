---
title: Grid
description: Multi-column layout component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Grid
vue_package: "@laravilt/schemas"
---

# Grid

Responsive multi-column layout for fields.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Grid;
use Laravilt\Forms\Components\TextInput;

Grid::make(2)
    ->schema([
        TextInput::make('first_name'),
        TextInput::make('last_name'),
    ]);
```

## Column Count

```php
<?php

// Two columns
Grid::make(2)->schema([...]);

// Three columns
Grid::make(3)->schema([...]);

// Set via method
Grid::make()
    ->columns(4)
    ->schema([...]);
```

## Responsive Columns

```php
<?php

Grid::make()
    ->columns([
        'default' => 1,  // Mobile
        'sm' => 2,       // 640px+
        'md' => 3,       // 768px+
        'lg' => 4,       // 1024px+
    ])
    ->schema([...]);
```

## Column Span

```php
<?php

Grid::make(3)
    ->schema([
        TextInput::make('title')
            ->columnSpan(2),

        TextInput::make('status'),

        TextInput::make('description')
            ->columnSpanFull(),
    ]);
```

## Nested Grids

```php
<?php

Grid::make(2)
    ->schema([
        Grid::make(2)
            ->schema([
                TextInput::make('first_name'),
                TextInput::make('last_name'),
            ]),
        TextInput::make('email'),
    ]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string\|int\|array)` | Create grid |
| `columns(int\|array)` | Set columns |
| `schema(array)` | Child components |
| `getColumns()` | Get columns |
| `getSchema()` | Get schema |

## Responsive Breakpoints

| Key | Width |
|-----|-------|
| `default` | 0px |
| `sm` | 640px |
| `md` | 768px |
| `lg` | 1024px |
| `xl` | 1280px |
| `2xl` | 1536px |

## Related

- [Section](section) - Grouped content
- [Tabs](tabs) - Tabbed interface

