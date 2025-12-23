---
title: Picker Fields
description: Specialized picker components
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
concept: pickers
---

# Picker Fields

Specialized selection components.

## Available Components

| Component | Description | Vue Package |
|-----------|-------------|-------------|
| `ColorPicker` | Color selection | vue-color / native |
| `IconPicker` | Icon selection | Custom + Lucide |
| `TagsInput` | Multi-tag input | Radix Vue TagsInput |
| `Slider` | Range slider | Radix Vue Slider |

## ColorPicker

```php
<?php

use Laravilt\Forms\Components\ColorPicker;

ColorPicker::make('brand_color')
    ->label('Brand Color')
    ->default('#3b82f6');
```

Vue component uses native color input or vue-color:

```vue
<template>
  <input type="color" v-model="modelValue" />
</template>
```

## IconPicker

```php
<?php

use Laravilt\Forms\Components\IconPicker;

IconPicker::make('icon')
    ->label('Select Icon')
    ->searchable();
```

Uses Lucide icons:

```vue
<script setup>
import * as icons from 'lucide-vue-next'
</script>
```

## TagsInput

```php
<?php

use Laravilt\Forms\Components\TagsInput;

TagsInput::make('tags')
    ->suggestions(['php', 'laravel', 'vue'])
    ->max(5);
```

## Slider

```php
<?php

use Laravilt\Forms\Components\Slider;

Slider::make('volume')
    ->min(0)
    ->max(100)
    ->step(1);
```

Uses Radix Vue Slider:

```vue
<script setup>
import { Slider } from '@/components/ui/slider'
</script>
```

## Related

- [ColorPicker](color-picker) - Color selection
- [IconPicker](icon-picker) - Icon selection
- [TagsInput](tags-input) - Tag input
- [Slider](slider) - Range slider
