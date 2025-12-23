---
title: Section
description: Collapsible container with heading
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: schemas
vue_component: Section
vue_package: "@laravilt/schemas"
---

# Section

Group related fields with heading and icon.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Forms\Components\TextInput;

Section::make('User Information')
    ->schema([
        TextInput::make('name'),
        TextInput::make('email'),
    ]);
```

## With Description

```php
<?php

Section::make('Contact Details')
    ->description('How users can reach you')
    ->schema([
        TextInput::make('phone'),
        TextInput::make('address'),
    ]);
```

## With Icon

```php
<?php

Section::make('Settings')
    ->description('Configure preferences')
    ->icon('Settings')
    ->schema([...]);
```

## Collapsible

```php
<?php

// Collapsible, starts expanded
Section::make('Advanced Options')
    ->collapsible()
    ->schema([...]);

// Collapsible, starts collapsed
Section::make('Optional Settings')
    ->collapsible()
    ->collapsed()
    ->schema([...]);
```

## Multi-Column Layout

```php
<?php

Section::make('Address')
    ->columns(2)
    ->schema([
        TextInput::make('street'),
        TextInput::make('city'),
    ]);

// Responsive columns
Section::make('Details')
    ->columns([
        'default' => 1,
        'sm' => 2,
        'lg' => 3,
    ])
    ->schema([...]);
```

## Methods

| Method | Description |
|--------|-------------|
| `make(?string)` | Create section |
| `heading(string\|Closure)` | Set heading |
| `description(string\|Closure)` | Set description |
| `icon(string\|Closure)` | Lucide icon |
| `schema(array)` | Child components |
| `columns(int\|array)` | Column layout |
| `collapsible(bool)` | Enable collapse |
| `collapsed(bool)` | Start collapsed |

## Getters

| Method | Return |
|--------|--------|
| `getHeading()` | `?string` |
| `getDescription()` | `?string` |
| `getIcon()` | `?string` |
| `getColumns()` | `int\|array\|null` |
| `getSchema()` | `array` |
| `isCollapsible()` | `bool` |
| `isCollapsed()` | `bool` |

## Related

- [Grid](grid) - Multi-column layout
- [Tabs](tabs) - Tabbed interface

