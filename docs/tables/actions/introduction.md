---
title: Table Actions
description: Row and bulk actions
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: actions
---

# Table Actions

Row and bulk actions for tables.

## Action Types

| Type | Description |
|------|-------------|
| [Row Actions](row-actions) | Single record actions |
| [Bulk Actions](bulk-actions) | Multiple records |
| [Header Actions](header-actions) | Table header actions |

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;
use Laravilt\Actions\ViewAction;
use Laravilt\Actions\EditAction;
use Laravilt\Actions\DeleteAction;
use Laravilt\Actions\DeleteBulkAction;

$table
    ->actions([
        ViewAction::make(),
        EditAction::make(),
        DeleteAction::make(),
    ])
    ->bulkActions([
        DeleteBulkAction::make(),
    ]);
```

## Fixed Actions

```php
<?php

use Laravilt\Tables\Table;

$table
    ->fixedActions()
    ->actions([...]);
```

## Related

- [Row Actions](row-actions) - Single record
- [Bulk Actions](bulk-actions) - Multiple records
- [Header Actions](header-actions) - Table header
