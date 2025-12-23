---
title: Grid View
description: Card-based grid layout
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: display
vue_component: TableGridView
---

# Grid View

Card-based grid layout with `->card()`.

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Tables\Card;

$table
    ->columns([...])
    ->card(
        Card::product(
            imageField: 'thumbnail',
            titleField: 'name',
            priceField: 'price',
            descriptionField: 'description'
        )
    )
    ->cardsPerRow(3);
```

## Grid Only Mode

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Tables\Card;

$table
    ->card(Card::simple(
        titleField: 'name',
        descriptionField: 'description'
    ))
    ->gridOnly();
```

## Cards Per Row

```php
<?php

use Laravilt\Tables\Table;

$table
    ->cardsPerRow(4)
    ->cardsPerRowSm(2)
    ->cardsPerRowMd(3)
    ->cardsPerRowLg(4);
```

## Card Actions Position

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Tables\Card;

$table
    ->card(
        Card::make()
            ->actionsPosition('bottom')  // top, bottom, overlay
    );
```

## API Reference

| Method | Description |
|--------|-------------|
| `card()` | Set card config |
| `gridOnly()` | Hide table view |
| `cardsPerRow()` | Cards per row |
| `cardsPerRowSm()` | Cards on small |
| `cardsPerRowMd()` | Cards on medium |
| `cardsPerRowLg()` | Cards on large |
