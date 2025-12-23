---
title: Column Visibility
description: Toggle column visibility
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
vue_component: TableColumnToggle
vue_package: "radix-vue (Checkbox)"
---

# Column Visibility

Allow users to toggle column visibility.

## Toggleable Columns

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('created_at')
    ->toggleable();

TextColumn::make('updated_at')
    ->toggleable(isToggledHiddenByDefault: true);
```

## Non-Toggleable Columns

```php
<?php

use Laravilt\Tables\Columns\TextColumn;

TextColumn::make('name')
    ->toggleable(false);
```

## All Toggleable by Default

```php
<?php

use Laravilt\Tables\Table;

$table->toggleableColumns();
```

## Vue Component

Uses Radix Vue Checkbox:

```vue
<script setup>
import { CheckboxRoot, CheckboxIndicator } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `toggleable()` | Make toggleable |
| `isToggledHiddenByDefault` | Hidden by default |
| `toggleableColumns()` | All toggleable |
