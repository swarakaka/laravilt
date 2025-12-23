---
title: Radio
description: Radio button group
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Radio
vue_component: FormRadioGroup
vue_package: "radix-vue (RadioGroup)"
---

# Radio

Radio group for mutually exclusive selection.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Radio;

Radio::make('payment_method')
    ->options([
        'card' => 'Credit Card',
        'paypal' => 'PayPal',
        'bank' => 'Bank Transfer',
    ]);
```

## With Descriptions

```php
<?php

use Laravilt\Forms\Components\Radio;

Radio::make('plan')
    ->options([
        'basic' => 'Basic',
        'pro' => 'Professional',
    ])
    ->descriptions([
        'basic' => '$9/month',
        'pro' => '$29/month',
    ]);
```

## Inline Display

```php
<?php

use Laravilt\Forms\Components\Radio;

Radio::make('gender')
    ->options(['male' => 'Male', 'female' => 'Female'])
    ->inline();
```

## Vue Component

Uses Radix Vue RadioGroup:

```vue
<script setup>
import { RadioGroupRoot, RadioGroupItem } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `options()` | Set options |
| `descriptions()` | Add descriptions |
| `inline()` | Display inline |
| `live()` | Enable reactivity |
