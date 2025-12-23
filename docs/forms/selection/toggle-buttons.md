---
title: ToggleButtons
description: Button-style toggle controls
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: ToggleButtons
vue_component: FormToggleGroup
vue_package: "radix-vue (ToggleGroup)"
---

# ToggleButtons

Button-style toggle for visual selection.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\ToggleButtons;

ToggleButtons::make('status')
    ->options([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ]);
```

## Grouped Buttons

```php
<?php

use Laravilt\Forms\Components\ToggleButtons;

ToggleButtons::make('alignment')
    ->options(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'])
    ->grouped();
```

## With Icons

```php
<?php

use Laravilt\Forms\Components\ToggleButtons;

ToggleButtons::make('view_mode')
    ->options(['grid' => 'Grid', 'list' => 'List'])
    ->icons(['grid' => 'LayoutGrid', 'list' => 'List']);
```

## Multiple Selection

```php
<?php

use Laravilt\Forms\Components\ToggleButtons;

ToggleButtons::make('features')
    ->options(['bold' => 'B', 'italic' => 'I', 'underline' => 'U'])
    ->multiple()
    ->grouped();
```

## Vue Component

Uses Radix Vue ToggleGroup:

```vue
<script setup>
import { ToggleGroupRoot, ToggleGroupItem } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `options()` | Set options |
| `grouped()` | Group buttons |
| `icons()` | Add icons |
| `boolean()` | Boolean mode |
| `multiple()` | Allow multiple |
| `colors()` | Color per option |
