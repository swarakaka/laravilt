---
title: Infolist Layouts
description: Layout components for infolists
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
concept: layouts
---

# Infolist Layouts

Layout components for organizing infolist entries.

## Available Layouts

| Layout | Description |
|--------|-------------|
| [Section](section) | Grouped entries with heading |
| [Grid](grid) | Multi-column layouts |
| [Tabs](tabs) | Tabbed content panels |
| [Split](split) | Side-by-side layout |
| [Fieldset](fieldset) | Bordered grouping |

## Basic Usage

```php
<?php

use Laravilt\Infolists\Infolist;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Grid;

Infolist::make()
    ->schema([
        Section::make('User Info')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                ]),
            ]),
    ]);
```

## Nesting Layouts

```php
<?php

use Laravilt\Schemas\Components\Section;
use Laravilt\Schemas\Components\Tabs;
use Laravilt\Schemas\Components\Tab;

Section::make('Details')
    ->schema([
        Tabs::make()->schema([
            Tab::make('Profile')->schema([...]),
            Tab::make('Settings')->schema([...]),
        ]),
    ]);
```

## Related

- [Section](section) - Grouped entries
- [Grid](grid) - Column layouts
- [Tabs](tabs) - Tabbed content
