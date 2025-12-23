---
title: Reordering
description: Drag-and-drop row reordering
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
concept: features
vue_component: TableReorder
vue_package: "@vueuse/integrations (useSortable)"
---

# Reordering

Drag-and-drop row reordering.

## Basic Usage

```php
<?php

use Laravilt\Tables\Table;

$table
    ->reorderable('sort_order')
    ->defaultSort('sort_order', 'asc');
```

## Model Setup

```php
<?php

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['name', 'sort_order'];
}
```

## Migration

```php
<?php

Schema::create('menu_items', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

## Reorder Callback

```php
<?php

use Laravilt\Tables\Table;

$table
    ->reorderable('sort_order')
    ->onReorder(function ($record, $newPosition) {
        // Custom logic after reorder
    });
```

## Vue Component

Uses @vueuse sortable:

```vue
<script setup>
import { useSortable } from '@vueuse/integrations/useSortable'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `reorderable()` | Column to store order |
| `defaultSort()` | Default sort column |
| `onReorder()` | Callback after reorder |
