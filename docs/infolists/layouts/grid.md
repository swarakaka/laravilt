---
title: Grid
description: Multi-column layouts
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: Grid
vue_component: InfolistGrid
---

# Grid

Create multi-column layouts for entries.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Grid;
use Laravilt\Infolists\Entries\TextEntry;

Grid::make(2)
    ->schema([
        TextEntry::make('first_name'),
        TextEntry::make('last_name'),
        TextEntry::make('email'),
        TextEntry::make('phone'),
    ]);
```

## Three Columns

```php
<?php

use Laravilt\Schemas\Components\Grid;
use Laravilt\Infolists\Entries\TextEntry;

Grid::make(3)
    ->schema([
        TextEntry::make('city'),
        TextEntry::make('state'),
        TextEntry::make('country'),
    ]);
```

## Responsive Columns

```php
<?php

use Laravilt\Schemas\Components\Grid;

Grid::make([
    'default' => 1,
    'sm' => 2,
    'lg' => 3,
    'xl' => 4,
])->schema([...]);
```

## Column Span

```php
<?php

use Laravilt\Schemas\Components\Grid;
use Laravilt\Infolists\Entries\TextEntry;

Grid::make(3)
    ->schema([
        TextEntry::make('title'),
        TextEntry::make('status'),
        TextEntry::make('description')->columnSpan(2),
    ]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `make()` | Number of columns |
| `columnSpan()` | Entry column span |
| `columns()` | Responsive columns |
