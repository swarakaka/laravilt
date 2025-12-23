---
title: Split
description: Side-by-side layout
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: Split
vue_component: InfolistSplit
---

# Split

Create side-by-side layouts with main and aside content.

## Basic Usage

```php
<?php

use Laravilt\Schemas\Components\Split;
use Laravilt\Schemas\Components\Section;
use Laravilt\Infolists\Entries\TextEntry;
use Laravilt\Infolists\Entries\ImageEntry;

Split::make([
    Section::make()
        ->schema([
            TextEntry::make('name'),
            TextEntry::make('email'),
            TextEntry::make('bio'),
        ]),
    Section::make()
        ->grow(false)
        ->schema([
            ImageEntry::make('avatar')->circular(),
        ]),
]);
```

## Custom Ratio

```php
<?php

use Laravilt\Schemas\Components\Split;
use Laravilt\Schemas\Components\Section;

Split::make([
    Section::make()->schema([...]),
    Section::make()->grow(false)->schema([...]),
])->from('md');
```

## Reverse Order

```php
<?php

use Laravilt\Schemas\Components\Split;

Split::make([...])
    ->from('lg');
```

## API Reference

| Method | Description |
|--------|-------------|
| `from()` | Breakpoint to split |
| `grow()` | Allow section growth |
