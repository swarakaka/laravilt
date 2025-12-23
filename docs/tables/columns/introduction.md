---
title: Table Columns
description: Column types for data tables
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: columns
---

# Table Columns

8 column types for displaying data.

## Available Columns

| Column | Description | Editable |
|--------|-------------|----------|
| [TextColumn](text-column) | Text with formatting | No |
| [ImageColumn](image-column) | Images with stacking | No |
| [IconColumn](icon-column) | Lucide icons | No |
| [ColorColumn](color-column) | Color swatches | No |
| [ToggleColumn](toggle-column) | Toggle switch | Yes |
| [SelectColumn](select-column) | Dropdown | Yes |
| [TextInputColumn](text-input-column) | Text input | Yes |
| [CheckboxColumn](checkbox-column) | Checkbox | Yes |

## Common Features

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->label('Full Name')
    ->searchable()
    ->sortable()
    ->toggleable()
    ->visible(fn () => auth()->user()->isAdmin());
```

## Alignment

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('price')
    ->alignEnd()
    ->prefix('$');
```

## Related

- [Text Column](text-column) - Text display
- [Image Column](image-column) - Image display
- [Toggle Column](toggle-column) - Inline toggle
