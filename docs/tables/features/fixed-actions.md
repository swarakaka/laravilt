---
title: Fixed Actions
description: Sticky actions column
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
vue_component: TableActions
---

# Fixed Actions

Keep actions column visible while scrolling.

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;

$table
    ->fixedActions()
    ->actions([
        \Laravilt\Actions\ViewAction::make(),
        \Laravilt\Actions\EditAction::make(),
        \Laravilt\Actions\DeleteAction::make(),
    ]);
```

## Actions Position

```php
<?php

use Laravilt\Tables\Table;

$table
    ->fixedActions()
    ->actionsPosition('start'); // 'start' or 'end' (default)
```

## Column Width

```php
<?php

use Laravilt\Tables\Table;

$table
    ->fixedActions()
    ->actionsColumnWidth('150px');
```

## With Grouping

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Actions\ActionGroup;

$table
    ->fixedActions()
    ->actions([
        ActionGroup::make([
            \Laravilt\Actions\ViewAction::make(),
            \Laravilt\Actions\EditAction::make(),
            \Laravilt\Actions\DeleteAction::make(),
        ])->dropdown(),
    ]);
```

## API Reference

| Method | Description |
|--------|-------------|
| `fixedActions()` | Enable sticky actions |
| `actionsPosition()` | start or end |
| `actionsColumnWidth()` | Column width |
