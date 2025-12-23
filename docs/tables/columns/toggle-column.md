---
title: ToggleColumn
description: Inline toggle switch
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: ToggleColumn
vue_component: TableToggleCell
vue_package: "radix-vue (Switch)"
---

# ToggleColumn

Inline toggle switch for boolean values.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\ToggleColumn;

ToggleColumn::make('is_active')
    ->label('Active');
```

## With State Update

```php
<?php

use Laravilt\Tables\Columns\ToggleColumn;
use Laravilt\Notifications\Notification;

ToggleColumn::make('is_featured')
    ->afterStateUpdated(function ($record, $state) {
        $record->update(['is_featured' => $state]);

        Notification::make()
            ->title('Status updated')
            ->success()
            ->send();
    });
```

## With Validation

```php
<?php

use Laravilt\Tables\Columns\ToggleColumn;

ToggleColumn::make('is_published')
    ->rules(['boolean'])
    ->disabled(fn ($record) => $record->is_locked);
```

## API Reference

| Method | Description |
|--------|-------------|
| `beforeStateUpdated()` | Before update hook |
| `afterStateUpdated()` | After update hook |
| `rules()` | Validation rules |
| `disabled()` | Disable toggle |
