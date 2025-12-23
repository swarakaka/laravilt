---
title: IconEntry
description: Icon display with boolean mode
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: IconEntry
vue_component: InfolistIconEntry
---

# IconEntry

Lucide icons with dynamic colors and boolean mode.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\IconEntry;

IconEntry::make('type')
    ->icon('Package');
```

## Boolean Mode

```php
<?php

use Laravilt\Infolists\Entries\IconEntry;

IconEntry::make('is_verified')
    ->boolean();

IconEntry::make('is_active')
    ->boolean()
    ->trueIcon('CheckCircle')
    ->falseIcon('XCircle')
    ->trueColor('success')
    ->falseColor('danger');
```

## Dynamic Icon

```php
<?php

use Laravilt\Infolists\Entries\IconEntry;

IconEntry::make('status')
    ->icon(fn (string $state): string => match ($state) {
        'pending' => 'Clock',
        'processing' => 'Loader',
        'completed' => 'CheckCircle',
    });
```

## Size & Color

```php
<?php

use Laravilt\Infolists\Entries\IconEntry;

IconEntry::make('priority')
    ->icon('Flag')
    ->size('lg')
    ->color('danger');
```

## API Reference

| Method | Description |
|--------|-------------|
| `icon()` | Set icon name |
| `boolean()` | Boolean mode |
| `trueIcon()` | Icon for true |
| `falseIcon()` | Icon for false |
| `trueColor()` | Color for true |
| `falseColor()` | Color for false |
| `size()` | Icon size |
| `color()` | Icon color |
