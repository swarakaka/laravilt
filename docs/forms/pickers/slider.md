---
title: Slider
description: Range slider control
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Slider
vue_component: FormSlider
vue_package: "radix-vue (Slider)"
---

# Slider

Range slider for numeric values.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Slider;

Slider::make('volume')
    ->label('Volume');
```

## Range Configuration

```php
<?php

use Laravilt\Forms\Components\Slider;

Slider::make('price')
    ->min(0)
    ->max(1000)
    ->step(10);
```

## Show Value

```php
<?php

use Laravilt\Forms\Components\Slider;

Slider::make('brightness')
    ->min(0)
    ->max(100)
    ->showValue();
```

## With Marks

```php
<?php

use Laravilt\Forms\Components\Slider;

Slider::make('rating')
    ->min(1)
    ->max(5)
    ->marks([1 => 'Poor', 3 => 'Average', 5 => 'Excellent']);
```

## Vue Component

Uses Radix Vue Slider:

```vue
<script setup>
import { SliderRoot, SliderTrack, SliderThumb } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `min()` | Minimum value |
| `max()` | Maximum value |
| `step()` | Step increment |
| `showValue()` | Show current value |
| `marks()` | Add tick marks |
