---
title: Selection Fields
description: Dropdown and toggle selection components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: selection
---

# Selection Fields

Components for selecting from predefined options.

## Available Components

| Component | Description | Vue Component |
|-----------|-------------|---------------|
| `Select` | Dropdown with search | `Select` from shadcn/ui |
| `Radio` | Radio button group | `RadioGroup` from shadcn/ui |
| `Checkbox` | Single checkbox | `Checkbox` from shadcn/ui |
| `CheckboxList` | Multiple checkboxes | Custom component |
| `Toggle` | Boolean switch | `Switch` from shadcn/ui |
| `ToggleButtons` | Button-style toggles | `ToggleGroup` from shadcn/ui |

## Common Pattern

All selection fields use options:

```php
<?php

use Laravilt\Forms\Components\Select;

Select::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
    ])
    ->required();
```

## Dynamic Options

```php
Select::make('category_id')
    ->options(fn () => Category::pluck('name', 'id'))
    ->searchable();
```

## Relationship Loading

```php
Select::make('user_id')
    ->relationship('user', 'name')
    ->searchable()
    ->preload();
```

## Vue Component Pattern

Selection components use Radix Vue primitives:

```vue
<template>
  <FieldWrapper :label="label" :errors="errors">
    <Select v-model="modelValue">
      <SelectTrigger>
        <SelectValue :placeholder="placeholder" />
      </SelectTrigger>
      <SelectContent>
        <SelectItem
          v-for="(label, value) in options"
          :key="value"
          :value="value"
        >
          {{ label }}
        </SelectItem>
      </SelectContent>
    </Select>
  </FieldWrapper>
</template>
```

## Related

- [Select](select) - Dropdown selection
- [Radio](radio) - Radio buttons
- [Checkbox](checkbox) - Single checkbox
- [CheckboxList](checkbox-list) - Multiple checkboxes
- [Toggle](toggle) - Boolean switch
- [ToggleButtons](toggle-buttons) - Button toggles
