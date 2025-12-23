---
title: Table Features
description: Advanced table features
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
---

# Table Features

Advanced table features and behaviors.

## Available Features

| Feature | Description |
|---------|-------------|
| [Searching](searching) | Global search |
| [Sorting](sorting) | Column sorting |
| [Reordering](reordering) | Drag-and-drop rows |
| [Grouping](grouping) | Row grouping |
| [Column Visibility](column-visibility) | Toggle columns |
| [Fixed Actions](fixed-actions) | Sticky actions column |
| [Polling](polling) | Auto-refresh data |

## Basic Table Settings

```php
<?php

use Laravilt\Tables\Table;

$table
    ->searchable()
    ->defaultSort('created_at', 'desc')
    ->striped()
    ->hoverable();
```

## Related

- [Searching](searching) - Search configuration
- [Reordering](reordering) - Drag-and-drop
- [Grouping](grouping) - Row grouping
- [Fixed Actions](fixed-actions) - Sticky column
