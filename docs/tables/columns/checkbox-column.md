---
title: CheckboxColumn
description: Inline checkbox column
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: CheckboxColumn
vue_component: TableCheckboxCell
vue_package: "radix-vue (Checkbox)"
---

# CheckboxColumn

Inline checkbox for boolean values.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\CheckboxColumn;

CheckboxColumn::make('agreed_to_terms')
    ->label('Terms');
```

## With State Update

```php
<?php

use Laravilt\Tables\Columns\CheckboxColumn;
use Laravilt\Notifications\Notification;

CheckboxColumn::make('is_verified')
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['is_verified' => $state]);

        Notification::make()
            ->title('Verified status updated')
            ->success()
            ->send();
    });
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
| `beforeStateUpdated()` | Before update hook |
| `afterStateUpdated()` | After update hook |
| `rules()` | Validation rules |
