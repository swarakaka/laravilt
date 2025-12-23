---
title: CheckboxList
description: Multiple checkbox group
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: forms
component: CheckboxList
vue_component: FormCheckboxList
vue_package: "radix-vue (Checkbox)"
---

# CheckboxList

Multiple checkboxes for selecting multiple options.

## Basic Usage

```php
<?php

use Laravilt\Forms\Components\CheckboxList;

CheckboxList::make('technologies')
    ->options([
        'php' => 'PHP',
        'laravel' => 'Laravel',
        'vue' => 'Vue.js',
    ]);
```

## Multi-Column Layout

```php
<?php

use Laravilt\Forms\Components\CheckboxList;

CheckboxList::make('permissions')
    ->options([
        'create' => 'Create',
        'read' => 'Read',
        'update' => 'Update',
        'delete' => 'Delete',
    ])
    ->columns(2);
```

## Bulk Toggle

```php
<?php

use Laravilt\Forms\Components\CheckboxList;

CheckboxList::make('features')
    ->options(['sso' => 'SSO', '2fa' => '2FA'])
    ->bulkToggleable();
```

## Vue Component

Uses Radix Vue Checkbox:

```vue
<script setup>
import { CheckboxRoot, CheckboxIndicator } from 'radix-vue'
</script>
```

## API Reference

| Method | Description |
|--------|-------------|
| `options()` | Set options |
| `columns()` | Set column count |
| `bulkToggleable()` | Enable bulk toggle |
| `descriptions()` | Add descriptions |
| `relationship()` | Load from relation |
