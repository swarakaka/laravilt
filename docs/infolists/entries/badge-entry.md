---
title: BadgeEntry
description: Styled badges with colors and icons
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: BadgeEntry
vue_component: InfolistBadgeEntry
---

# BadgeEntry

Styled badges with dynamic colors and icons.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\BadgeEntry;

BadgeEntry::make('status');
```

## Color Mapping

```php
<?php

use Laravilt\Infolists\Entries\BadgeEntry;

BadgeEntry::make('status')
    ->colors([
        'draft' => 'gray',
        'pending' => 'warning',
        'approved' => 'success',
        'rejected' => 'danger',
    ]);
```

## Icon Mapping

```php
<?php

use Laravilt\Infolists\Entries\BadgeEntry;

BadgeEntry::make('status')
    ->icons([
        'draft' => 'FileEdit',
        'pending' => 'Clock',
        'approved' => 'CheckCircle',
        'rejected' => 'XCircle',
    ]);
```

## Conditional Color

```php
<?php

use Laravilt\Infolists\Entries\BadgeEntry;

BadgeEntry::make('score')
    ->color(fn (int $state): string => match (true) {
        $state >= 90 => 'success',
        $state >= 70 => 'warning',
        default => 'danger',
    });
```

## API Reference

| Method | Description |
|--------|-------------|
| `colors()` | Color mapping array |
| `icons()` | Icon mapping array |
| `bool()` | Boolean mode |
| `color()` | Dynamic color |
