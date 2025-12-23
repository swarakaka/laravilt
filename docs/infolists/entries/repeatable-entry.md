---
title: RepeatableEntry
description: Display collections and arrays
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: RepeatableEntry
vue_component: InfolistRepeatableEntry
---

# RepeatableEntry

Display arrays or collections with nested schemas.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\RepeatableEntry;
use Laravilt\Infolists\Entries\TextEntry;

RepeatableEntry::make('addresses')
    ->schema([
        TextEntry::make('street'),
        TextEntry::make('city'),
        TextEntry::make('country'),
    ]);
```

## Collapsible Items

```php
<?php

use Laravilt\Infolists\Entries\RepeatableEntry;
use Laravilt\Infolists\Entries\TextEntry;

RepeatableEntry::make('order_items')
    ->collapsible()
    ->collapsed()
    ->schema([
        TextEntry::make('product.name'),
        TextEntry::make('quantity'),
        TextEntry::make('price')->money('USD'),
    ]);
```

## Empty State

```php
<?php

use Laravilt\Infolists\Entries\RepeatableEntry;
use Laravilt\Infolists\Entries\TextEntry;

RepeatableEntry::make('comments')
    ->emptyMessage('No comments yet')
    ->schema([
        TextEntry::make('author'),
        TextEntry::make('content'),
    ]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `schema()` | Nested entries |
| `collapsible()` | Enable collapse |
| `collapsed()` | Start collapsed |
| `emptyMessage()` | Empty state text |
