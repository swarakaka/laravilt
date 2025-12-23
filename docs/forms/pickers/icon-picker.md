---
title: IconPicker
description: Icon selection field
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: IconPicker
vue_component: FormIconPicker
vue_package: "lucide-vue-next"
---

# IconPicker

Icon selection from Lucide library.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\IconPicker;

IconPicker::make('icon')
    ->label('Select Icon');
```

## Searchable

```php
<?php

use Laravilt\Forms\Components\IconPicker;

IconPicker::make('menu_icon')
    ->searchable();
```

## Custom Icons

```php
<?php

use Laravilt\Forms\Components\IconPicker;

IconPicker::make('action_icon')
    ->options([
        'Edit' => 'Edit',
        'Trash2' => 'Delete',
        'Eye' => 'View',
    ]);
```

## Vue Component

Uses Lucide icons:

```vue
<script setup>
import * as icons from 'lucide-vue-next'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `searchable()` | Enable search |
| `options()` | Custom icons |
| `columns()` | Grid columns |
