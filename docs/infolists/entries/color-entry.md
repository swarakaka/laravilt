---
title: ColorEntry
description: Color swatch display
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: infolists
component: ColorEntry
vue_component: InfolistColorEntry
---

# ColorEntry

Color swatches with copy functionality.

## Basic Usage

```php
<?php

use Laravilt\Infolists\Entries\ColorEntry;

ColorEntry::make('brand_color');
```

## Show Label

```php
<?php

use Laravilt\Infolists\Entries\ColorEntry;

ColorEntry::make('color')
    ->showLabel();
```

## Copyable

```php
<?php

use Laravilt\Infolists\Entries\ColorEntry;

ColorEntry::make('hex')
    ->copyable();
```

## Size Options

```php
<?php

use Laravilt\Infolists\Entries\ColorEntry;

ColorEntry::make('color')
    ->size('lg'); // xs, sm, md, lg, xl
```

## API Reference

| Method | Description |
|--------|-------------|
| `showLabel()` | Show hex value |
| `copyable()` | Enable copy |
| `size()` | Swatch size |
