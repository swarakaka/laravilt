---
title: Split
description: Two-pane layout component
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Split
vue_package: "@laravilt/schemas"
---

# Split

Two-pane layout for content and sidebar.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Split;
use Laravilt\Forms\Components\TextInput;

Split::make()
    ->startSchema([
        TextInput::make('title'),
        TextInput::make('content'),
    ])
    ->endSchema([
        TextInput::make('status'),
    ]);
```

## Left/Right Aliases

```php
<?php

Split::make()
    ->leftSchema([
        TextInput::make('title'),
    ])
    ->rightSchema([
        TextInput::make('sidebar'),
    ]);
```

## Responsive Breakpoint

```php
<?php

Split::make()
    ->fromBreakpoint('md')  // Stack below md
    ->startSchema([...])
    ->endSchema([...]);
```

## Custom Column Spans

```php
<?php

Split::make()
    ->fromBreakpoint('lg')
    ->startColumnSpan('md:col-span-8')
    ->endColumnSpan('md:col-span-4')
    ->startSchema([...])
    ->endSchema([...]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(string)` | Create split |
| `fromBreakpoint(string)` | Stack breakpoint |
| `startSchema(array)` | Left content |
| `endSchema(array)` | Right content |
| `leftSchema(array)` | Alias for start |
| `rightSchema(array)` | Alias for end |
| `startColumnSpan(string\|int)` | Left width |
| `endColumnSpan(string\|int)` | Right width |

## Getters

| Method | Return |
|--------|--------|
| `getFromBreakpoint()` | `string` |
| `getStartSchema()` | `array` |
| `getEndSchema()` | `array` |
| `getLeftSchema()` | `array` |
| `getRightSchema()` | `array` |

## Related

- [Section](section) - Grouped content
- [Grid](grid) - Multi-column layout

