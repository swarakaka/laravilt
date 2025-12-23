---
title: IconColumn
description: Icon display column
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: IconColumn
vue_component: TableIconCell
vue_package: "lucide-vue-next"
---

# IconColumn

Display Lucide icons with colors.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\IconColumn;

IconColumn::make('icon')
    ->icon(fn ($record) => $record->icon_name);
```

## Boolean Mode

```php
<?php

use Laravilt\Tables\Columns\IconColumn;

IconColumn::make('is_verified')
    ->boolean()
    ->trueIcon('CheckCircle')
    ->falseIcon('XCircle')
    ->trueColor('success')
    ->falseColor('danger');
```

## Dynamic Icons

```php
<?php

use Laravilt\Tables\Columns\IconColumn;

IconColumn::make('status_icon')
    ->icon(fn ($record) => match($record->status) {
        'active' => 'CheckCircle',
        'pending' => 'Clock',
        default => 'AlertCircle',
    })
    ->color(fn ($record) => match($record->status) {
        'active' => 'success',
        default => 'secondary',
    });
```

## API Reference

| Method | Description |
|--------|-------------|
| `icon()` | Icon name |
| `color()` | Icon color |
| `boolean()` | Boolean mode |
| `trueIcon()` | True icon |
| `falseIcon()` | False icon |
| `size()` | Icon size |
