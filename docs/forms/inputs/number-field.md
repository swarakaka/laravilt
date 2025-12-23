---
title: NumberField
description: Numeric input with controls
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: NumberField
vue_component: FormNumberInput
vue_package: "radix-vue (NumberField)"
---

# NumberField

Numeric input with increment/decrement controls.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\NumberField;

NumberField::make('quantity')
    ->label('Quantity');
```

## Value Range

```php
<?php

use Laravilt\Forms\Components\NumberField;

NumberField::make('age')
    ->minValue(0)
    ->maxValue(120);
```

## Step Increment

```php
<?php

use Laravilt\Forms\Components\NumberField;

NumberField::make('price')
    ->step(0.01)
    ->prefix('$');
```

## Vue Component

Uses Radix Vue NumberField:

```vue
<script setup>
import { NumberFieldRoot } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `minValue()` | Minimum value |
| `maxValue()` | Maximum value |
| `step()` | Step increment |
| `prefix()` | Prefix text |
| `suffix()` | Suffix text |
