---
title: Table Display
description: Table and grid view options
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: display
---

# Table Display

Table and grid view display options.

## Display Modes

| Mode | Description |
|------|-------------|
| Table View | Default row-based display |
| [Grid View](grid-view) | Card-based grid layout |
| [Cards](cards) | Card type configurations |
| [Pagination](pagination) | Page & infinite scroll |

## Basic Configuration

```php
<?php

use Laravilt\Tables\Table;

$table
    ->striped()
    ->hoverable()
    ->bordered();
```

## Empty State

```php
<?php

use Laravilt\Tables\Table;

$table
    ->emptyStateHeading('No records found')
    ->emptyStateDescription('Create your first record')
    ->emptyStateIcon('Inbox');
```

## Related

- [Grid View](grid-view) - Card grid layout
- [Cards](cards) - Card types
- [Pagination](pagination) - Pagination options
