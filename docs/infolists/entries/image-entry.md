---
title: ImageEntry
description: Image display entry
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: ImageEntry
vue_component: InfolistImageEntry
---

# ImageEntry

Display images and avatars.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\ImageEntry;

ImageEntry::make('avatar')
    ->circular()
    ->size(80);
```

## Shapes

```php
<?php

use Laravilt\Infolists\Entries\ImageEntry;

ImageEntry::make('photo')->rounded();
ImageEntry::make('avatar')->circular();
```

## Stacked Images

```php
<?php

use Laravilt\Infolists\Entries\ImageEntry;

ImageEntry::make('team_photos')
    ->stacked()
    ->limit(4)
    ->ring(2)
    ->limitedRemainingText();
```

## Default Image

```php
<?php

use Laravilt\Infolists\Entries\ImageEntry;

ImageEntry::make('avatar')
    ->defaultImageUrl('/images/default-avatar.png');
```

## API Reference

| Method | Description |
|--------|-------------|
| `circular()` | Round shape |
| `rounded()` | Rounded corners |
| `size()` | Width/height |
| `stacked()` | Stack multiple |
| `limit()` | Max images |
| `ring()` | Border ring |
| `defaultImageUrl()` | Fallback |
