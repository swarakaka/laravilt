---
title: Repeater
description: Dynamic repeating field groups
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Repeater
vue_component: FormRepeater
vue_package: "@vueuse/core (useSortable)"
---

# Repeater

Dynamic repeating field groups.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Repeater;
use Laravilt\Forms\Components\TextInput;

Repeater::make('contacts')
    ->schema([
        TextInput::make('name')->required(),
        TextInput::make('email')->email(),
    ]);
```

## Item Limits

```php
<?php

use Laravilt\Forms\Components\Repeater;
use Laravilt\Forms\Components\TextInput;

Repeater::make('features')
    ->schema([
        TextInput::make('name'),
    ])
    ->minItems(1)
    ->maxItems(10);
```

## Reorderable

```php
<?php

use Laravilt\Forms\Components\Repeater;

Repeater::make('steps')
    ->schema([...])
    ->reorderable()
    ->collapsible();
```

## Vue Component

Uses @vueuse/core for drag:

```vue
<script setup>
import { useSortable } from '@vueuse/integrations/useSortable'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `schema()` | Set field schema |
| `minItems()` | Minimum items |
| `maxItems()` | Maximum items |
| `reorderable()` | Enable reordering |
| `collapsible()` | Enable collapse |
| `cloneable()` | Enable cloning |
