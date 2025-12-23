---
title: ColorPicker
description: Color selection field
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: ColorPicker
vue_component: FormColorPicker
vue_package: "native input[type=color]"
---

# ColorPicker

Color selection with format options.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\ColorPicker;

ColorPicker::make('color')
    ->label('Brand Color');
```

## Color Format

```php
<?php

use Laravilt\Forms\Components\ColorPicker;

ColorPicker::make('primary_color')->format('hex');
ColorPicker::make('background')->format('rgb');
ColorPicker::make('overlay')->format('rgba');
```

## Preset Swatches

```php
<?php

use Laravilt\Forms\Components\ColorPicker;

ColorPicker::make('theme_color')
    ->swatches([
        '#3b82f6', '#ef4444', '#22c55e',
        '#f59e0b', '#8b5cf6', '#06b6d4',
    ]);
```

## Vue Component

Uses native color input:

```vue
<template>
  <input type="color" v-model="modelValue" />
</template>
```

## API Reference

| Method | Description |
|--------|-------------|
| `format()` | Set color format |
| `swatches()` | Preset swatches |
| `default()` | Default color |
