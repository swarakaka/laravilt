---
title: ColorColumn
description: Color swatch display
version: 1.0.0
laravel: "12.x"
php: "8.2+"
updated: 2025-01-15
category: tables
component: ColorColumn
vue_component: TableColorCell
---

# ColorColumn

Display color swatches with copy.

## Basic Usage

```php
<?php

use Laravilt\Tables\Columns\ColorColumn;

ColorColumn::make('color')
    ->label('Brand Color');
```

## Copyable

```php
<?php

use Laravilt\Tables\Columns\ColorColumn;

ColorColumn::make('hex_color')
    ->copyable()
    ->copyMessage('Color copied!');
```

## Multiple Colors

```php
<?php

use Laravilt\Tables\Columns\ColorColumn;

ColorColumn::make('palette')
    ->wrap();
```

## API Reference

| Method | Description |
|--------|-------------|
| `copyable()` | Enable copy |
| `copyMessage()` | Copy message |
| `wrap()` | Wrap colors |
