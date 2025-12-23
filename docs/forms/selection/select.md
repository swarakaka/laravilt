---
title: Select
description: Dropdown selection with search and relationships
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: selection
vue_component: Select
vue_package: "@/components/ui/select"
---

# Select

Dropdown selection with search, multiple selection, and relationship support.

## Vue Component

Uses `Select` from **shadcn/ui** (Radix Vue based).

```vue
<script setup>
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
</script>
```

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Select;

Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ]);
```

## Searchable

```php
Select::make('country')
    ->searchable()
    ->options(Country::pluck('name', 'id'));
```

## Multiple Selection

```php
Select::make('tags')
    ->multiple()
    ->minItems(1)
    ->maxItems(5);
```

## Relationship Loading

```php
Select::make('category_id')
    ->relationship('category', 'name')
    ->searchable()
    ->preload();
```

## Create Option Inline

```php
Select::make('category_id')
    ->relationship('category', 'name')
    ->createOptionForm([
        TextInput::make('name')->required(),
    ]);
```

## Dependent Selects

```php
Select::make('country_id')
    ->options(Country::pluck('name', 'id'))
    ->live();

Select::make('state_id')
    ->options(fn ($get) => State::where('country_id', $get('country_id'))->pluck('name', 'id'))
    ->dependsOn('country_id');
```

## API Reference

| Method | Description |
|--------|-------------|
| `options()` | Set options array |
| `searchable()` | Enable search |
| `multiple()` | Allow multiple |
| `relationship()` | Load from relation |
| `preload()` | Preload options |
| `native()` | Use native select |
| `dependsOn()` | Field dependency |

## Related

- [Radio](radio) - Radio buttons
- [CheckboxList](checkbox-list) - Multiple checkboxes
