---
title: Toggle
description: Boolean toggle switch
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: Toggle
vue_component: FormSwitch
vue_package: "radix-vue (Switch)"
---

# Toggle

Boolean toggle switch for on/off states.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\Toggle;

Toggle::make('is_active')
    ->label('Active');
```

## Custom Colors

```php
<?php

use Laravilt\Forms\Components\Toggle;

Toggle::make('published')
    ->onColor('success')
    ->offColor('danger');
```

## With Icons

```php
<?php

use Laravilt\Forms\Components\Toggle;

Toggle::make('notifications')
    ->onIcon('Bell')
    ->offIcon('BellOff');
```

## Reactive Toggle

```php
<?php

use Laravilt\Forms\Components\Toggle;

Toggle::make('has_discount')
    ->live()
    ->afterStateUpdated(function ($state, $set) {
        if (!$state) {
            $set('discount_percentage', null);
        }
    });
```

## Vue Component

Uses Radix Vue Switch:

```vue
<script setup>
import { SwitchRoot, SwitchThumb } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `onColor()` | Color when on |
| `offColor()` | Color when off |
| `onIcon()` | Icon when on |
| `offIcon()` | Icon when off |
| `live()` | Enable reactivity |
